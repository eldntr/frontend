<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Transaction;
use Illuminate\Support\Facades\Http;
use App\Models\User; // Added import for User model

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $sellerId = session('user')['id'];

        // Hitung Total Produk
        $totalProducts = Product::where('seller_id', $sellerId)->count();

        // Hitung Total Terjual (produk yang telah dibeli dan status 'paid' atau 'shipped')
        $totalSold = OrderItem::whereHas('order', function ($query) {
        // Menggunakan whereIn untuk memeriksa dua status
            $query->whereIn('status', ['paid', 'shipped']);
        })->whereHas('product', function ($query) use ($sellerId) {
            $query->where('seller_id', $sellerId);
        })->sum('quantity');

        // Hitung Order yang Sedang Diproses (status 'pending')
        $ordersInProcess = Order::where('status', 'paid')->whereHas('orderItems.product', function ($query) use ($sellerId) {
            $query->where('seller_id', $sellerId);
        })->count();

        //shippeditem
        $shippedOrders = Order::with('orderItems.product')->where('status', 'shipped')->get();

        // Mendapatkan daftar produk milik seller
        $products = Product::where('seller_id', $sellerId)->get();

        // Mendapatkan daftar orders yang sudah dibayar
        $orders = Order::where('status', 'paid') // Ambil hanya yang sudah dibayar
            ->with('orderItems.product') // Load order items dan produk
            ->get();

        return view('products.index', compact('products', 'totalProducts', 'totalSold', 'ordersInProcess', 'orders', 'shippedOrders'));
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
            'category_id' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $price = (int) $request->price;
        $stock = (int) $request->stock;
        $category_id = (int) $request->category_id;

        // $categories = session('category', []);
        // $categoryName = ; // Ganti dengan nama kategori yang ingin dicari
        // $category = collect($categories)->firstWhere('name', $categoryName);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $price,
            'stock' => $stock,
            'seller_id' => session('user')['id'],
            'category_id' => $category_id,
            'image' => $imagePath,
        ];

        $response = Http::post('http://localhost:8080/products', $data);

        // Buat Testing

        // if ($response->successful()) {
        //     $result = $response->json();
        //     dd($result);
        // } else {
        //     dd([
        //         'url' => 'http://localhost:8080/products',
        //         'data' => $data,
        //         'response' => $response->body(),
        //         'status' => $response->status(),
        //     ]);
        // }

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
        try {
            $response = Http::get("http://localhost:8080/products/{$id}");
            
            if (!$response->successful()) {
                \Log::error("Failed to fetch product data from API: " . $response->body());
                abort(500, 'Failed to fetch product data.');
            }

            $productData = $response->json();
            $user = auth()->user();

            // Fetch reviews
            $reviewsResponse = Http::get("http://localhost:8080/reviewsproduct/{$id}");
            if ($reviewsResponse->successful()) {
                $reviews = $reviewsResponse->json();
                $productData['reviews'] = array_map(function($review) {
                    $user = User::find($review['user_id']);
                    $review['user'] = ['name' => $user ? $user->name : 'Unknown'];
                    return $review;
                }, $reviews);
            } else {
                $productData['reviews'] = [];
            }

            // Fetch discussions with replies
            $discussionsResponse = Http::get("http://localhost:8080/product/{$id}/discussions");
            if ($discussionsResponse->successful()) {
                $discussions = $discussionsResponse->json();
                
                // Process discussions and their replies
                $productData['discussions'] = array_map(function($discussion) {
                    // Get discussion author
                    $discussionUser = User::find($discussion['user_id']);
                    $discussion['user'] = ['name' => $discussionUser ? $discussionUser->name : 'Unknown'];
                    
                    // Process replies if they exist
                    if (!empty($discussion['replies'])) {
                        $discussion['replies'] = array_map(function($reply) {
                            $replyUser = User::find($reply['user_id']);
                            $reply['user'] = ['name' => $replyUser ? $replyUser->name : 'Unknown'];
                            return $reply;
                        }, $discussion['replies']);
                    } else {
                        $discussion['replies'] = [];
                    }
                    
                    return $discussion;
                }, $discussions);
            } else {
                \Log::error("Failed to fetch discussions: " . $discussionsResponse->body());
                $productData['discussions'] = [];
            }

            $isWishlisted = false;

            return view('products.show', compact('productData', 'isWishlisted'));
        } catch (\Exception $e) {
            \Log::error("An error occurred in show method: " . $e->getMessage());
            abort(500, 'An unexpected error occurred.');
        }
    }

    public function storeReview(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        // Convert the data types to match Go API expectations
        $reviewData = [
            'product_id' => (int)$productId,
            'user_id' => (int)Auth::id(),
            'rating' => (int)$request->rating,
            'comment' => (string)$request->comment,
        ];

        // Log the request data
        \Log::info('Sending review data to API:', $reviewData);

        $response = Http::post('http://localhost:8080/reviews', $reviewData);

        // Log the response
        \Log::info('API Response:', [
            'status' => $response->status(),
            'body' => $response->body()
        ]);

        if ($response->successful()) {
            return redirect()->back()->with('success', 'Review added successfully!');
        }

        return redirect()->back()->with('error', 'Failed to add review. ' . $response->body());
    }

    public function search(Request $request)
    {
        $user = auth()->user();
        $searchTerm = $request->input('search');

        \Log::info('Search term: ' . $searchTerm);

        $products = Product::where('name', 'LIKE', '%' . $searchTerm . '%')->get();

        foreach ($products as $product) {
            $product->isWishlisted = $user ? $product->wishlistedBy->contains($user) : false;
        }

        return view('home', compact('products'));
    }
}
