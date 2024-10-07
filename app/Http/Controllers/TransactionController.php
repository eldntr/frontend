<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // Menampilkan semua transaksi
    public function index()
    {
        $transactions = Transaction::with(['user', 'product'])->get();
        return view('transactions.index', compact('transactions'));
    }

    // Menyimpan transaksi baru
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
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
}
