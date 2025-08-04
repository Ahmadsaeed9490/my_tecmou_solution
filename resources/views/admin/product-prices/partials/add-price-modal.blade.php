<div class="mb-3">
  <label for="product_id" class="form-label">Select Product</label>
  <select name="product_id" id="product_id" class="form-control" required>
    <option value="">-- Select Product --</option>
    @foreach($products as $product)
      <option value="{{ $product->id }}">{{ $product->name }}</option>
    @endforeach
  </select>
</div>

<div class="mb-3">
  <label>Min Price</label>
  <input type="number" name="min_price" class="form-control" required>
</div>

<div class="mb-3">
    <label>Max Price</label>
    <input type="number" name="max_price" class="form-control" step="0.1" required>
</div>

<div class="mb-3">
    <label>Discount Percent</label>
    <input type="number" name="discount_percent" class="form-control" step="0.1" required>
</div>

<div class="mb-3">
    <label>Final Price</label>
    <input type="number" name="final_price" class="form-control" step="0.1" required>
</div>

<div class="mb-3">
    <label>Currency</label>
    <input type="text,number" name="currency" class="form-control" required>
</div>
