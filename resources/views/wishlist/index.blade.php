<!DOCTYPE html>
<html>
<head>
    <title>Wishlist</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Your Wishlist</h2>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="row">
        @if(count($wishlists) > 0)
            @foreach($wishlists as $product)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        @else
                            <img src="https://via.placeholder.com/150" class="card-img-top" alt="No Image">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text"><strong>Price:</strong> ${{ $product->price }}</p>
                            <form action="{{ route('wishlist.moveToCart', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">Move to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <p>Your wishlist is empty.</p>
            </div>
        @endif
    </div>
</div>
</body>
</html>