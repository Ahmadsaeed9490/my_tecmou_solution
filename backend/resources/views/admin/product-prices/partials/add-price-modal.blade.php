<div class="mb-3">
  {{-- <label for="product_id" class="form-label">Select Product</label> --}}
  <select name="product_id" id="product_id" class="form-control" required>
    {{-- <option value="">-- Select Product --</option> --}}
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
    <select name="currency" class="form-control" required>
        <option value="">Select Currency</option>
        <option value="USD">USD</option> <!-- United States Dollar -->
        <option value="EUR">EUR</option> <!-- Euro -->
        <option value="GBP">GBP</option> <!-- British Pound -->
        <option value="JPY">JPY</option> <!-- Japanese Yen -->
        <option value="CNY">CNY</option> <!-- Chinese Yuan -->
        <option value="INR">INR</option> <!-- Indian Rupee -->
        <option value="PKR">PKR</option> <!-- Pakistani Rupee -->
        <option value="AUD">AUD</option> <!-- Australian Dollar -->
        <option value="CAD">CAD</option> <!-- Canadian Dollar -->
        <option value="AED">AED</option> <!-- UAE Dirham -->
    </select>
</div>

