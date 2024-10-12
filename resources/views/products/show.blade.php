<div class="container">
    <h1>{{ $product->name }}</h1>
    <p>{{ $product->description }}</p>
    <p><strong>Price:</strong> ${{ $product->price }}</p>

    <h2>Reviews</h2>
    @if($product->reviews->isEmpty())
    <p>No reviews yet.</p>
    @else
    @foreach($product->reviews as $review)
    <div>
        <strong>{{ $review->user->name }}</strong>
        <span>{{ $review->rating }} / 5</span>
        <p>{{ $review->comment }}</p>
    </div>
    @endforeach
    @endif


    <h2>Add a Review</h2>
    <!-- Display validation errors -->
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('reviews.store', $product->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="rating">Rating</label>
            <input type="number" name="rating" id="rating" class="form-control" min="1" max="5" required>
        </div>
        <div class="form-group">
            <label for="comment">Comment</label>
            <textarea name="comment" id="comment" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>