<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
{{-- <div class="container mt-5">
        <h2 class="mb-4">Your Cart</h2>
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        <div class="row">
            @if($cart && count($cart->items) > 0)
            @foreach($cart->items as $item)
            <div class="col-md-4 mb-4">
                <div class="card">
                    @if($item->product->image)
                    <img src="{{ asset('storage/' . $item->product->image) }}" class="card-img-top" alt="{{ $item->product->name }}">
                    @else
                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="No Image">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->product->name }}</h5>
                        <p class="card-text"><strong>Price:</strong> ${{ $item->product->price }}</p>
                        <p class="card-text"><strong>Quantity:</strong> {{ $item->quantity }}</p>
                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">Remove</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
            <!-- Tambahkan Tombol Checkout di Bawah -->
            <div class="col-md-12">
                <form action="{{ route('checkout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-block">Checkout</button>
                </form>
            </div>
            @else
            <div class="col-12">
                <p>Your cart is empty.</p>
            </div>
            @endif
        </div>
    </div> --}}
<x-navbar></x-navbar>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<section class="bg-white py-8 antialiased dark:bg-gray-900 md:py-16">
    <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
      @if($cart && count($cart->items) > 0)
        <h2 class="text-xl font-bold text-gray-900 dark:text-white sm:text-2xl">Shopping Carts</h2>
        <div class="mt-6 sm:mt-8 md:gap-6 lg:flex lg:items-start xl:gap-8">
          <div class="mx-auto w-full flex-none lg:max-w-2xl xl:max-w-4xl">
            <div class="space-y-6">
              @foreach ($cart->items as $item )
                  <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 md:p-6">
                      <div class="space-y-4 md:flex md:items-center md:justify-between md:gap-6 md:space-y-0">
                      <a href="#" class="shrink-0 md:order-1">
                          <img class="h-20 w-20 dark:hidden" src="{{ $item->product->image ? asset('storage/' . $item->product->image) : 'https://via.placeholder.com/150' }}" alt="{{ $item->product->name }}" />
                      </a>
          
                      <label for="counter-input" class="sr-only">Choose quantity:</label>
                      <div class="flex items-center justify-between md:order-3 md:justify-end">
                          <div class="flex items-center">
                            <form action="{{ route('cart.decrementQuantity', $item->id) }}" method="POST">
                              @csrf
                              <button type="submit" id="decrement-button"
                              @if ($item->quantity <= 1)
                                disabled
                              @endif  
                              class="decrement-button inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-md border border-gray-300 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
                                <svg class="h-2.5 w-2.5 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16" />
                                </svg>
                              </button>
                            </form>
                              <input type="text" id="counter-input" data-input-counter class="w-10 shrink-0 border-0 bg-transparent text-center text-sm font-medium text-gray-900 focus:outline-none focus:ring-0 dark:text-white" placeholder="" value="{{ $item->quantity }}" required />
                            <form action="{{ route('cart.incrementQuantity', $item->id) }}" method="POST">  
                              @csrf
                              <button type="submit" id="increment-button" class="increment-button inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-md border border-gray-300 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
                                  <svg class="h-2.5 w-2.5 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                                  </svg>
                              </button>
                            </form>
                          </div>
                          <div class="text-end md:order-4 md:w-32">
                          <p class="text-base font-bold text-gray-900 dark:text-white">Rp.{{ $item->product->price * $item->quantity }}</p>
                          </div>
                      </div>
          
                      <div class="w-full min-w-0 flex-1 space-y-4 md:order-2 md:max-w-md">
                          <a href="#" class="text-base font-medium text-gray-900 hover:underline dark:text-white">{{ $item->product->name }}</a>
          
                          <div class="flex items-center gap-4">
                            <form action="{{ route('wishlist.add', $item->product->id) }}" method="POST">
                              @csrf
                              <button type="submit" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-900 hover:underline dark:text-gray-400 dark:hover:text-white">
                                  <svg class="mr-1.5 h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="{{ $item->product->isWishlisted ? '#ff1493' : 'none' }}" viewBox="0 0 24 24">
                                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.01 6.001C6.5 1 1 8 5.782 13.001L12.011 20l6.23-7C23 8 17.5 1 12.01 6.002Z" />
                                  </svg>
                                  {{ $item->product->isWishlisted ? 'In Wishlist' : 'Add to Wishlists' }}
                              </button>
                            </form>
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                              @csrf
                              <button type="submit" class="inline-flex items-center text-sm font-medium text-red-600 hover:underline dark:text-red-500">
                                <svg class="me-1.5 h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                                </svg>
                                Remove
                              </button>
                            </form>
                          </div>
                      </div>
                      </div>
                  </div>
              @endforeach
            </div>
          </div>
    
          <div class="mx-auto mt-6 max-w-4xl flex-1 space-y-6 lg:mt-0 lg:w-full">
            <div class="space-y-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
              <p class="text-xl font-semibold text-gray-900 dark:text-white">Order summary</p>
    
              <div class="space-y-4">
                <div class="space-y-2">
                  <dl class="flex items-center justify-between gap-4">
                    <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Original price</dt>
                    <dd class="text-base font-medium text-gray-900 dark:text-white">Rp.{{ $original_price }}</dd>
                  </dl>
    
                  <dl class="flex items-center justify-between gap-4">
                    <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Savings</dt>
                    <dd class="text-base font-medium text-green-600">-Rp.0</dd>
                  </dl>
                </div>
    
                <dl class="flex items-center justify-between gap-4 border-t border-gray-200 pt-2 dark:border-gray-700">
                  <dt class="text-base font-bold text-gray-900 dark:text-white">Total</dt>
                  <dd class="text-base font-bold text-gray-900 dark:text-white">Rp.{{ $total }}</dd>
                </dl>
              </div>
              <div class="flex flex-col items-center gap-4">
                <form action="{{ route('checkout') }}" method="POST">
                  @csrf
                  <button type="submit" class="flex w-full items-center justify-center rounded-lg bg-teal-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-teal-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-teal-600 dark:hover:bg-teal-700 dark:focus:ring-teal-800">
                      Proceed to Checkout
                  </button>
                </form>
            
                <div class="flex items-center justify-center gap-2">
                    <span class="text-sm font-normal text-gray-500 dark:text-gray-400"> or </span>
                    <a href="/" title="" class="inline-flex items-center gap-2 text-sm font-medium text-teal-700 underline hover:no-underline dark:text-teal-500">
                        Continue Shopping
                        <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4" />
                        </svg>
                    </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      @else
        <div class="flex items-center justify-center font-bold text-4xl text-gray-900 dark:text-white">
          Your Cart Is Empty
        </div>
      @endif
    </div>
</section>

</body>
</html>