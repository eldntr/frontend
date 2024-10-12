<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function add(Request $request, $productId)
    {
        $user = Auth::user();
        $user->wishlists()->attach($productId);

        return redirect()->back()->with('success', 'Product added to wishlist!');
    }

    public function index()
    {
        $user = Auth::user();
        $wishlists = $user->wishlists;

        return view('wishlist.index', compact('wishlists'));
    }

    public function moveToCart($productId)
    {
        $user = Auth::user();
        $user->wishlists()->detach($productId);

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

        return redirect()->route('cart.index')->with('success', 'Product moved to cart!');
    }
}