<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{

    public function createOrder(Request $request)
    {
        // Ambil user yang sedang login
        $user = Auth::user();
        
        // Ambil cart user beserta item-nya
        $cart = $user->carts()->with('items.product')->firstOrFail();

        // Buat order baru
        $order = Order::create([
            'buyer_id' => $user->id,
            'status' => 'pending',
            'total' => $cart->items->sum(function($item) {
                return $item->product->price * $item->quantity;
            }),
        ]);

        // Pindahkan setiap item dari cart ke order
        foreach ($cart->items as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->price,
            ]);
        }

        // Bersihkan cart setelah order dibuat
        $cart->items()->delete();

        return redirect()->route('transactions.index')->with('success', 'Order berhasil dibuat');
    }
    // Menampilkan semua transaksi
    public function index()
    {
        // Ambil transaksi berdasarkan user yang sedang login
        $orders = Order::where('buyer_id', Auth::id())->get();

        // Kirim data orders ke view transactions.index
        return view('transactions.index', compact('orders'));
    }

    // Menyimpan transaksi baru
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail
        (id: $request->product_id);
        $totalPrice = $product->price * $request->quantity;

        $transaction = Transaction::create([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Transaction created successfully!');
    }

    // Menampilkan detail transaksi
    public function show($id)
    {
        $transaction = Transaction::with(['user', 'product'])->findOrFail($id);
        return view('transactions.show', compact('transaction'));
    }

    // Mengupdate status transaksi
    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->update($request->only('status'));
        return redirect()->back()->with('success', 'Transaction status updated successfully');
    }

    // Menghapus transaksi
    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();
        return redirect()->back()->with('success', 'Transaction deleted successfully');
    }

    //list order
    public function listOrders()
    {
        $sellerId = Auth::id();

        $orders = Transaction::whereHas('product', function ($query) use ($sellerId) {
            $query->where('seller_id', $sellerId);
        })->get();

        return view('seller.orders', compact('orders'));
    }
}
