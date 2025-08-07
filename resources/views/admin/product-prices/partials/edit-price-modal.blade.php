<div class="mb-3">
  <label for="product_id" class="form-label">Select Product</label>



  {{-- Select dropdown for changing product --}}
  <select name="product_id" id="product_id" class="form-control mt-2" required>
    <option value="">-- Select Product --</option>
    @foreach($products as $product)
      <option value="{{ $product->id }}" 
        {{ (old('product_id') == $product->id || (isset($productPrice) && $productPrice->product_id == $product->id)) ? 'selected' : '' }}>
        {{ $product->name }}
      </option>
    @endforeach
  </select>
</div>



<div class="mb-3">
    <label>Min Price</label>
    <input type="number" name="min_price" class="form-control" step="0.01" 
        value="{{ $price->min_price ?? '' }}" required>
</div>

<div class="mb-3">
    <label>Max Price</label>
    <input type="number" name="max_price" class="form-control" step="0.01" 
        value="{{ $price->max_price ?? '' }}" required>
</div>

<div class="mb-3">
    <label>Discount Percent</label>
    <input type="number" name="discount_percent" class="form-control" step="0.01" 
        value="{{ $price->discount_percent ?? '' }}" required>
</div>

<div class="mb-3">
    <label>Final Price</label>
    <input type="number" name="final_price" class="form-control" step="0.01" 
        value="{{ $price->final_price ?? '' }}" required>
</div>

<div class="mb-3">
   <select name="currency" id="edit-currency" class="form-control" required>
    <option value="">Select Currency</option>
    <option value="USD">USD</option>
    <option value="EUR">EUR</option>
    <option value="GBP">GBP</option>
    <option value="JPY">JPY</option>
    <option value="CNY">CNY</option>
    <option value="INR">INR</option>
    <option value="PKR">PKR</option>
    <option value="AUD">AUD</option>
    <option value="CAD">CAD</option>
    <option value="AED">AED</option>
</select>

</div>

<script>
$(document).on('click', '.editBtn', function () {
    const id = $(this).data('id');

    $.ajax({
        url: '/admin/product-prices/' + id + '/edit',
        type: 'GET',
        success: function (res) {
            $('#editModal input[name="id"]').val(res.id);
            $('#editModal select[name="product_id"]').val(res.product_id); // 👈 SET SELECTED PRODUCT
            // other fields...
        }
    });
});
</script>

