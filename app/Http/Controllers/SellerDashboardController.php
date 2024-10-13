<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use Auth;

class SellerDashboardController extends Controller
{
    public function index()
    {
        $sellerId = Auth::id();
        
        // Get the total number of products for the seller
        $totalProducts = Product::where('seller_id', $sellerId)->count();

        // Get the total number of products sold
        $totalSold = Transaction::whereHas('product', function ($query) use ($sellerId) {
            $query->where('seller_id', $sellerId);
        })->where('status', 'completed')->sum('quantity');

        // Get the total number of orders in process
        $inProcess = Transaction::whereHas('product', function ($query) use ($sellerId) {
            $query->where('seller_id', $sellerId);
        })->where('status', 'pending')->count();

        return view('seller.dashboard', compact('totalProducts', 'totalSold', 'inProcess'));
    }
}
?>
