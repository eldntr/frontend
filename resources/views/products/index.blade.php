<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Products</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <x-navbar></x-navbar>

    <div class="container mx-auto mt-10 p-6 bg-white rounded-lg shadow">
        <h1 class="text-3xl font-bold">Seller Dashboard</h1>
        <p class="mt-2">Hi, {{ Auth::user()->name }}!</p> <!-- Ganti dengan nama seller -->

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mt-6">
            <div class="bg-green-100 border border-green-300 rounded-lg p-4 text-center shadow">
                <h2 class="text-lg font-semibold">Total Products</h2>
                <p class="text-2xl font-bold">{{ $totalProducts }}</p>
            </div>

            <div class="bg-blue-100 border border-blue-300 rounded-lg p-4 text-center shadow">
                <h2 class="text-lg font-semibold">Total Sold</h2>
                <p class="text-2xl font-bold">{{ $totalSold }}</p>
            </div>

            <div class="bg-yellow-100 border border-yellow-300 rounded-lg p-4 text-center shadow">
                <h2 class="text-lg font-semibold">Orders in Process</h2>
                <p class="text-2xl font-bold">{{ $ordersInProcess }}</p>
            </div>
        </div>

        <h2 class="mt-6 text-xl font-semibold mb-4">Your Products</h2>
        <a href="{{ route('products.create') }}" class="inline-block bg-teal-600 text-white px-4 py-2 rounded hover:bg-teal-700">Add Product</a>

        <div class="overflow-x-auto mt-4">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($products as $product)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $product->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $product->description }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $product->price }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $product->stock }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $product->category ? $product->category->name : 'No Category' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-thumbnail" width="100">
                                @else
                                    No Image
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('products.edit', $product->id) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 ml-2">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <h2 class="mt-6 text-xl font-semibold mb-4">Orders that Have Been Paid</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detail</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($orders as $order)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $order->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $order->total }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $order->created_at }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <ul>
                                    @foreach($order->orderItems as $item)
                                        <li>{{ $item->product->name }} ({{ $item->quantity }} pcs)</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($order->status === 'paid')
                                    <form action="{{ route('orders.markAsShipped', $order->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Mark as Shipped</button>
                                    </form>
                                @else
                                    <span class="text-yellow-500">Perlu Diproses</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <h2 class="mt-6 text-xl font-semibold mb-4">Orders that Have Shipped</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detail</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($shippedOrders as $shippedOrder)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $shippedOrder->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $shippedOrder->total }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $shippedOrder->created_at }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <ul>
                                    @foreach($shippedOrder->orderItems as $item)
                                        <li>{{ $item->product->name }} ({{ $item->quantity }} pcs)</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-green-500">Terkirim</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
