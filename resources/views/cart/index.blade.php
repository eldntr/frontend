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
        @if(count($cart) > 0)
            @foreach($cart as $id => $details)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        @if($details['image'])
                            <img src="{{ asset('storage/' . $details['image']) }}" class="card-img-top" alt="{{ $details['name'] }}">
                        @else
                            <img src="https://via.placeholder.com/150" class="card-img-top" alt="No Image">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $details['name'] }}</h5>
                            <p class="card-text"><strong>Price:</strong> ${{ $details['price'] }}</p>
                            <p class="card-text"><strong>Quantity:</strong> {{ $details['quantity'] }}</p>
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