<div class="mb-3">
    <label for="product_id" class="form-label">Product</label>
   <select name="product_id" id="edit-product-id" class="form-control" required>
    <option value="">-- Select Product --</option>
    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($product->id); ?>">
            <?php echo e($product->name); ?>

        </option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>

</div>


<div class="mb-3">
    <label>Min Price</label>
    <input type="number" name="min_price" class="form-control" step="0.01" 
        value="<?php echo e($price->min_price ?? ''); ?>" required>
</div>

<div class="mb-3">
    <label>Max Price</label>
    <input type="number" name="max_price" class="form-control" step="0.01" 
        value="<?php echo e($price->max_price ?? ''); ?>" required>
</div>

<div class="mb-3">
    <label>Discount Percent</label>
    <input type="number" name="discount_percent" class="form-control" step="0.01" 
        value="<?php echo e($price->discount_percent ?? ''); ?>" required>
</div>

<div class="mb-3">
    <label>Final Price</label>
    <input type="number" name="final_price" class="form-control" step="0.01" 
        value="<?php echo e($price->final_price ?? ''); ?>" required>
</div>

<div class="mb-3">
    <label for="currency" class="form-label">Currency</label>
    <select name="currency" id="edit-currency" class="form-control" required>
        <option value="">-- Select Currency --</option>
        <option value="USD" <?php echo e((isset($price) && $price->currency == 'USD') ? 'selected' : ''); ?>>USD - US Dollar</option>
        <option value="EUR" <?php echo e((isset($price) && $price->currency == 'EUR') ? 'selected' : ''); ?>>EUR - Euro</option>
        <option value="GBP" <?php echo e((isset($price) && $price->currency == 'GBP') ? 'selected' : ''); ?>>GBP - British Pound</option>
        <option value="PKR" <?php echo e((isset($price) && $price->currency == 'PKR') ? 'selected' : ''); ?>>PKR - Pakistani Rupee</option>
        <option value="INR" <?php echo e((isset($price) && $price->currency == 'INR') ? 'selected' : ''); ?>>INR - Indian Rupee</option>
        <option value="AUD" <?php echo e((isset($price) && $price->currency == 'AUD') ? 'selected' : ''); ?>>AUD - Australian Dollar</option>
        <option value="CAD" <?php echo e((isset($price) && $price->currency == 'CAD') ? 'selected' : ''); ?>>CAD - Canadian Dollar</option>
        <option value="CNY" <?php echo e((isset($price) && $price->currency == 'CNY') ? 'selected' : ''); ?>>CNY - Chinese Yuan</option>
        <option value="SAR" <?php echo e((isset($price) && $price->currency == 'SAR') ? 'selected' : ''); ?>>SAR - Saudi Riyal</option>
        <option value="AED" <?php echo e((isset($price) && $price->currency == 'AED') ? 'selected' : ''); ?>>AED - UAE Dirham</option>
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

<?php /**PATH C:\xampp\htdocs\my_tecmou_solution\backend\resources\views/admin/product-prices/partials/edit-price-modal.blade.php ENDPATH**/ ?>