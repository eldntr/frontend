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

            $seller = Http::get("http://localhost:8080/sellers/{$product['seller_id']}")->json();
            $product['seller_name'] = $seller['name'] ?? 'Unknown Seller';

            $reviews = Http::get("http://localhost:8080/reviewsproduct/{$product['id']}")->json();
            $averageRating = count($reviews) > 0 ? array_sum(array_column($reviews, 'rating')) / count($reviews) : 0;
            $product['average_rating'] = round($averageRating, 2);
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

            $seller = Http::get("http://localhost:8080/sellers/{$product['seller_id']}")->json();
            $product['seller_name'] = $seller['name'] ?? 'Unknown Seller';

            $reviews = Http::get("http://localhost:8080/reviewsproduct/{$product['id']}")->json();
            $averageRating = count($reviews) > 0 ? array_sum(array_column($reviews, 'rating')) / count($reviews) : 0;
            $product['average_rating'] = round($averageRating, 2);
        }

        return view('home', compact('products'));
    }
}