<!DOCTYPE html>
<html>
<head>
    <title>Home - Products</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

{{-- Navbar --}}
<x-navbar></x-navbar>

{{-- Content --}}
<div class= "max-w-screen-xl px-4 mx-auto 2xl:px-0 py-4 grid lg:grid-cols-3 sm:grid-cols-2 gap-4 items-center justify-center scale-90">
    @foreach ( $wishlisted as $item )
        <a href="{{ route('product.show', $item->id) }}" class="group relative block overflow-hidden">
            <form action="{{ route('wishlist.add', $item->id) }}" method="POST">
                @csrf
                <button
                    class="absolute end-4 top-4 z-10 rounded-full bg-white p-1.5 text-gray-900 transition hover:text-gray-900/75"
                >
                    <span class="sr-only">Wishlist</span>
                
                    <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="#ff1493"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="size-4"
                    >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"
                    />
                    </svg>
                </button>
            </form>

            <img
                src="{{ $item->image ? asset('storage/' . $item->image) : 'https://via.placeholder.com/150' }}"
                alt="{{ $item->name }}"
                class="rounded-lg h-64 w-full object-cover transition duration-500 group-hover:scale-105 sm:h-72"
            />
            
            <div class="relative border border-gray-100 bg-white p-6">
                
                <form action="{{ route('product.filter', $item->category->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="whitespace-nowrap rounded bg-teal-700 text-white px-3 py-1.5 text-xs font-medium transition hover:scale-105"> 
                        {{ Str::limit($item->category->name,30) }} 
                    </button>
                </form>

                <h3 class="mt-4 font-bold text-xl font-medium text-gray-900">{{ Str::limit($item->name,30) }}</h3>
            
                <p class="mt-1.5 font-bold text-md text-gray-700">Rp. {{ $item->price }}</p>
            
                <form action="{{ route('cart.add', $item->id) }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit"
                        class="block w-full rounded bg-teal-700 text-white p-4 text-sm font-medium transition hover:bg-teal-800 hover:scale-105"
                    >
                        Add to Cart
                    </button>
                </form>
            </div>
        </a>
    @endforeach
</div>


</body>
</html>