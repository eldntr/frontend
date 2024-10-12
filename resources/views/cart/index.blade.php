<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
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
                                @method('DELETE') <!-- Spoof DELETE method -->
                                <button type="submit" class="btn btn-danger">Remove</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <p>Your cart is empty.</p>
            </div>
        @endif
    </div>
</div>
</body>
</html>