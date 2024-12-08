<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $response = Http::get('http://localhost:8080/products');
        $products = $response->json();
        $user = auth()->user();

        foreach ($products as &$product) {
            $product['isWishlisted'] = $user ? in_array($user->id, array_column($product['wishlistedBy'] ?? [], 'id')) : false;
            $product['category_name'] = $product['category']['name'] ?? 'No Category';
        }

        return view('home', compact('products'));
    }

    public function categoryFilter($categoryId)
    {
        $response = Http::get("http://localhost:8080/products?category_id={$categoryId}");
        $products = $response->json();
        $user = auth()->user();

        foreach ($products as &$product) {
            $product['isWishlisted'] = $user ? in_array($user->id, array_column($product['wishlistedBy'] ?? [], 'id')) : false;
            $product['category_name'] = $product['category']['name'] ?? 'No Category';
        }

        return view('home', compact('products'));
    }
}