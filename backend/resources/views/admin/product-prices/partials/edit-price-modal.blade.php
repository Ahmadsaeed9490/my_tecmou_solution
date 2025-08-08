<div class="mb-3">
    <label for="product_id" class="form-label">Product</label>
   <select name="product_id" id="edit-product-id" class="form-control" required>
    <option value="">-- Select Product --</option>
    @foreach($products as $product)
        <option value="{{ $product->id }}">
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
    <label for="currency" class="form-label">Currency</label>
    <select name="currency" id="edit-currency" class="form-control" required>
        <option value="">-- Select Currency --</option>
        <option value="USD" {{ (isset($price) && $price->currency == 'USD') ? 'selected' : '' }}>USD - US Dollar</option>
        <option value="EUR" {{ (isset($price) && $price->currency == 'EUR') ? 'selected' : '' }}>EUR - Euro</option>
        <option value="GBP" {{ (isset($price) && $price->currency == 'GBP') ? 'selected' : '' }}>GBP - British Pound</option>
        <option value="PKR" {{ (isset($price) && $price->currency == 'PKR') ? 'selected' : '' }}>PKR - Pakistani Rupee</option>
        <option value="INR" {{ (isset($price) && $price->currency == 'INR') ? 'selected' : '' }}>INR - Indian Rupee</option>
        <option value="AUD" {{ (isset($price) && $price->currency == 'AUD') ? 'selected' : '' }}>AUD - Australian Dollar</option>
        <option value="CAD" {{ (isset($price) && $price->currency == 'CAD') ? 'selected' : '' }}>CAD - Canadian Dollar</option>
        <option value="CNY" {{ (isset($price) && $price->currency == 'CNY') ? 'selected' : '' }}>CNY - Chinese Yuan</option>
        <option value="SAR" {{ (isset($price) && $price->currency == 'SAR') ? 'selected' : '' }}>SAR - Saudi Riyal</option>
        <option value="AED" {{ (isset($price) && $price->currency == 'AED') ? 'selected' : '' }}>AED - UAE Dirham</option>
    </select>
</div>



<script>
function editPrice(id) {
    $.ajax({
        url: `/admin/product-prices/${id}/edit`,
        type: 'GET',
        success: function (data) {
            $('#edit-price-form').attr('action', `/admin/product-prices/${id}`);

            // ✅ Correct field ID for product select
$('#edit-product-id').val(data.product_id).change(); // ensures dropdown updates visually

            // ✅ Populate other fields
            $('#edit-price-form input[name="min_price"]').val(data.min_price);
            $('#edit-price-form input[name="max_price"]').val(data.max_price);
            $('#edit-price-form input[name="discount_percent"]').val(data.discount_percent);
            $('#edit-price-form input[name="final_price"]').val(data.final_price);
            $('#edit-price-form input[name="currency"]').val(data.currency);
            $('#currency-text').val(data.currency);

            $('#edit_price_Modal').modal('show');
        },
        error: function (xhr) {
            alert('Failed to load product price data.');
            console.log(xhr.responseText);
        }
    });
}

</script>

