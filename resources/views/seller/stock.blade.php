<h1>Update Stock for {{ $product->name }}</h1>

<form action="{{ route('seller.product.stock', $product->id) }}" method="POST">
    @csrf
    <label for="stock">New Stock Quantity:</label>
    <input type="number" id="stock" name="stock" min="0" required>
    
    <button type="submit">Update Stock</button>
</form>
