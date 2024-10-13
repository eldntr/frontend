<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product; // Import the Product model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login'); // Pastikan redirect hanya jika user belum login
        }

        $cart = $user->carts()->with('items.product')->first();

        foreach ($cart->items as $item) {
            $product = $item->product;
            $product->isWishlisted = $user ? $product->wishlistedBy->contains($user) : false;
        }

        return view('cart.index', compact('cart'));
    }

    public function add($productId)
    {
        $user = Auth::user();
        $product = Product::findOrFail($productId); // Use the imported Product model

        // Check if the user already has a cart
        $cart = $user->carts()->firstOrCreate(['buyer_id' => $user->id]);

        // Check if the product is already in the cart
        $cartItem = $cart->items()->where('product_id', $productId)->first();
        if ($cartItem) {
            // If the product is already in the cart, increase the quantity
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            // If the product is not in the cart, add it
            $cartItem = new CartItem([
                'product_id' => $productId,
                'quantity' => 1,
            ]);
            $cart->items()->save($cartItem);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }
    public function updateQuantity(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:cart_items,id',
            'quantity' => 'required|integer|min:1', // Pastikan quantity minimal 1
        ]);

        $cartItem = CartItem::find($request->item_id);
        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return response()->json([
            'success' => true,
            'totalPrice' => $cartItem->quantity * $cartItem->product->price, // Menghitung total harga
        ]);
    }

    public function remove($itemId)
    {
        $cartItem = CartItem::findOrFail($itemId);
        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Product removed from cart!');
    }
}