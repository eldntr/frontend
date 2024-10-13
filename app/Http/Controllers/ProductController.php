<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Transaction;


class ProductController extends Controller
{
    public function index()
{
    $sellerId = Auth::id();

    // Hitung Total Produk
    $totalProducts = Product::where('seller_id', $sellerId)->count();

    // Hitung Total Terjual
    $totalSold = Transaction::whereHas('product', function ($query) use ($sellerId) {
        $query->where('seller_id', $sellerId);
    })->where('status', 'completed')->sum('quantity');

    // Hitung Order yang Sedang Diproses
    $ordersInProcess = Transaction::whereHas('product', function ($query) use ($sellerId) {
        $query->where('seller_id', $sellerId);
    })->where('status', 'pending')->count();

    // Mendapatkan daftar produk milik seller
    $products = Product::where('seller_id', $sellerId)->get();

    return view('products.index', compact('products', 'totalProducts', 'totalSold', 'ordersInProcess'));
}


    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'seller_id' => Auth::id(),
            'category_id' => $request->category_id,
            'image' => $imagePath,
        ]);

        return redirect()->route('products.index');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'image' => $imagePath,
        ]);

        return redirect()->route('products.index');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return redirect()->route('products.index');
    }

    public function setDiscount(Request $request, $id)
    {
        $request->validate([
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'new_price' => 'nullable|numeric|min:0',
        ]);

        $product = Product::where('id', $id)->where('seller_id', Auth::id())->firstOrFail();

        if ($request->has('discount_percentage') && $request->input('discount_percentage') !== null) {
            $discountedPrice = $product->price * ((100 - $request->input('discount_percentage')) / 100);
            $product->price = $discountedPrice;
        } elseif ($request->has('new_price') && $request->input('new_price') !== null) {
            $product->price = $request->input('new_price');
        }

        $product->save();

        return redirect()->back()->with('success', 'Discount has been applied successfully!');
    }

    public function manageStock(Request $request, $id)
    {
        $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $product = Product::where('id', $id)->where('seller_id', Auth::id())->firstOrFail();

        $product->stock = $request->input('stock');
        $product->save();

        return redirect()->back()->with('success', 'Stock updated successfully!');
    }

        public function show($id)
    {
        $product = Product::with('reviews.user')->findOrFail($id);
        return view('products.show', compact('product'));
    }
}
