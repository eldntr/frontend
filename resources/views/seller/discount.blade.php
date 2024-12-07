<form action="{{ route('seller.product.discount', $product->id) }}" method="POST">
    @csrf
    <label for="discount_percentage">Discount Percentage (%):</label>
    <input type="number" id="discount_percentage" name="discount_percentage" min="0" max="100">
    
    <label for="new_price">Or New Price:</label>
    <input type="number" id="new_price" name="new_price" min="0" step="0.01">
    
    <button type="submit">Apply Discount</button>
</form>
