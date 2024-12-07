<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $user = auth()->user();

        foreach ($products as $product) {
            $product->isWishlisted = $user ? $product->wishlistedBy->contains($user) : false;
        }

        return view('home', compact('products'));
    }

    public function categoryFilter($categoryId)
    {
        $user = auth()->user();
        $products = Product::where('category_id', $categoryId)->get();

        foreach ($products as $product) {
            $product->isWishlisted = $user ? $product->wishlistedBy->contains($user) : false;
        }

        return view('home', compact('products'));
    }
}