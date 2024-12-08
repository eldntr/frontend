<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <x-navbar></x-navbar>
    <div class="container mx-auto mt-10 p-6 bg-white rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-4">Edit Profile</h2>
        <form action="{{ route('users.update', session('user')['id']) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Name:</label>
                <input type="text" name="name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-teal-500" value="{{ session('user')['name'] }}" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Email:</label>
                <input type="email" name="email" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-teal-500" value="{{ session('user')['email'] }}" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Password:</label>
                <input type="password" name="password" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-teal-500" placeholder="Leave blank to keep current password">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Role:</label>
                <select name="role" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-teal-500" required>
                    <option value="buyer" {{ session('user')['role'] == 'buyer' ? 'selected' : '' }}>Buyer</option>
                    <option value="seller" {{ session('user')['role'] == 'seller' ? 'selected' : '' }}>Seller</option>
                    <option value="admin" {{ session('user')['role'] == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <button type="submit" class="bg-teal-600 text-white px-4 py-2 rounded hover:bg-teal-700">Update Profile</button>
        </form>
    </div>
</body>
</html>
