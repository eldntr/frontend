<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <x-navbar></x-navbar>
    <div class="container mx-auto mt-10 p-6 bg-white rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-4">Edit Product</h2>
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Name:</label>
                <input type="text" name="name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-teal-500" value="{{ $product->name }}" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Description:</label>
                <textarea name="description" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-teal-500">{{ $product->description }}</textarea>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Price:</label>
                <input type="number" name="price" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-teal-500" value="{{ $product->price }}" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Stock:</label>
                <input type="number" name="stock" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-teal-500" value="{{ $product->stock }}" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Category:</label>
                <select name="category_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-teal-500" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Image:</label>
                <input type="file" name="image" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-teal-500">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="mt-2" width="150">
                @endif
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update Product</button>
        </form>
    </div>
</body>
</html>