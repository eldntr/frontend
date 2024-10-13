<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <title>Document</title>
</head>
<body>
    <x-navbar></x-navbar>

    <section class="py-8 bg-white md:py-16 dark:bg-gray-900 antialiased">
        <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0">
          <div class="grid lg:grid-cols-2 lg:gap-8 xl:gap-16">
            <div class="shrink-0 max-w-md lg:max-w-lg mx-auto">
              <img class="w-full dark:hidden" src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/150' }}" alt="{{ $product->name }}" />
            </div>
    
            <div class="mt-6 sm:mt-8 lg:mt-0">
              <h1
                class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white"
              >
                {{ $product->name }}
              </h1>
              <h1>
                Stock: {{ $product->stock }}
              </h1>
              <div class="mt-4 sm:items-center sm:gap-4 sm:flex">
                <p
                  class="text-2xl font-extrabold text-gray-900 sm:text-3xl dark:text-white"
                >
                Rp.{{ $product->price }}
                </p>
              </div>
    
              <div class="mt-6 gap-4 sm:items-center sm:flex sm:mt-8">
                <form action="{{ route('wishlist.add', $product->id) }}" method="POST">
                  @csrf
                  <button
                    type="submit"
                    class="flex items-center justify-center py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                  >
                    <svg
                      class="w-5 h-5 -ms-2 me-2"
                      aria-hidden="true"
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      fill="{{ $isWishlisted ? '#ff1493' : 'none' }}"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12.01 6.001C6.5 1 1 8 5.782 13.001L12.011 20l6.23-7C23 8 17.5 1 12.01 6.002Z"
                      />
                    </svg>
                    {{ $isWishlisted ? 'In Wishlist' : 'Add to Wishlists' }}
                  </button>
                </form>
                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                  @csrf
                  <button
                    type="submit"
                    class="flex items-center justify-center py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-teal-700 rounded-lg border border-gray-200 hover:bg-teal-800 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-teal-600 dark:text-white dark:border-gray-600 dark:hover:bg-teal-700"
                  >
                    <svg
                      class="w-5 h-5 -ms-2 me-2"
                      aria-hidden="true"
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      fill="none"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 4h1.5L8 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm.75-3H7.5M11 7H6.312M17 4v6m-3-3h6"
                      />
                    </svg>
      
                    Add to cart
                  </button>
                </form>
              </div>
    
              <hr class="mt-6 md:my-8 border-gray-200 dark:border-gray-800" />
    
              <p class="mt-6 mb-6 text-gray-500 dark:text-gray-400">
                {{ $product->description }}
              </p>
            </div>
          </div>
        </div>
    </section>
</body>
</html>