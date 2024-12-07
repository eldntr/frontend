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

<div class="container">
    <h1>{{ $product->name }}</h1>
    <p>{{ $product->description }}</p>
    <p><strong>Price:</strong> ${{ $product->price }}</p>

    <h2>Diskusi</h2>
    @foreach($product->discussions as $discussion)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $discussion->user->name }} <small>{{ $discussion->created_at->format('M Y') }}</small></h5>
                <p class="card-text">{{ $discussion->content }}</p>
                <button class="btn btn-link" onclick="toggleReplies({{ $discussion->id }})">Lihat Balasan</button>
                <div id="replies-{{ $discussion->id }}" style="display: none;">
                    @foreach($discussion->replies as $reply)
                        <div class="card mt-2">
                            <div class="card-body">
                                <h6 class="card-title">{{ $reply->user->name }} <small>{{ $reply->created_at->format('M Y') }}</small></h6>
                                <p class="card-text">{{ $reply->content }}</p>
                            </div>
                        </div>
                    @endforeach
                    <form action="{{ route('discussions.reply', $discussion->id) }}" method="POST" class="mt-2">
                        @csrf
                        <div class="form-group">
                            <textarea name="content" class="form-control" placeholder="Isi komentar disini..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Balas</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <h2>Tambah Pertanyaan</h2>
    <form action="{{ route('discussions.store', $product->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <textarea name="content" class="form-control" placeholder="Isi pertanyaan disini..." required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Kirim</button>
    </form>
</div>

<script>
    function toggleReplies(discussionId) {
        var repliesDiv = document.getElementById('replies-' + discussionId);
        if (repliesDiv.style.display === 'none') {
            repliesDiv.style.display = 'block';
        } else {
            repliesDiv.style.display = 'none';
        }
    }
</script>