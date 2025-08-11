<style>
    .ck-editor__editable_inline {
        min-height: 150px;
    }
</style>



<input type="hidden" name="id" id="edit-id">

<div class="col-md-6">
  <label>Name</label>
  <input type="text" name="name" id="edit-name" class="form-control" value="<?php echo e($product->name ?? ''); ?>">
</div>

<div class="col-md-6">
  <label>Slug</label>
  <input type="text" name="slug" id="edit-slug" class="form-control" value="<?php echo e($product->slug ?? ''); ?>">
</div>

<div class="col-md-6">
  <label>SKU</label>
  <input type="text" name="sku" id="edit-sku" class="form-control" value="<?php echo e($product->sku ?? ''); ?>">
</div>

<div class="col-md-6">
  <label>Model</label>
  <input type="text" name="model" id="edit-model" class="form-control" value="<?php echo e($product->model ?? ''); ?>">
</div>

<div class="col-md-6">
  <label>Category</label>
  <select name="category_id" id="edit-category" class="form-control">
    <option value="">Select Category</option>
    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>

</div>

<div class="col-md-6">
  <label>Brand</label>
 <select name="brand_id" id="edit-brand" class="form-control" required>
    <option value="">Select Brand</option>
    <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($brand->id); ?>"><?php echo e($brand->name); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>
</div>

<div class="col-md-6">
  <label>Price</label>
  <input type="number" name="price" id="edit-price" class="form-control" value="<?php echo e($product->price ?? ''); ?>" step="0.01" min="0">
</div>

<div class="col-md-6">
  <label>Discount (%)</label>
  <input type="number" name="discount" id="edit-discount" class="form-control" value="<?php echo e($product->discount ?? ''); ?>" step="0.01" min="0" max="100">
</div>

<div class="col-md-6">
  <label>Stock Quantity</label>
  <input type="number" name="stock_quantity" id="edit-stock" class="form-control" value="<?php echo e($product->stock_quantity ?? ''); ?>" min="0">
</div>

<div class="col-md-6">
  <label>Status</label>
  <select name="status" id="edit-status" class="form-select">
    <option value="1">Active</option>
    <option value="0">Inactive</option>
  </select>
</div>

<div class="col-md-6">
  <label>Is Featured?</label>
  <select name="is_featured" id="edit-featured" class="form-select">
    <option value="0">No</option>
    <option value="1">Yes</option>
  </select>
</div>

<!-- Edit Product Modal -->
<div class="col-12">
    <label>Description</label>
    <textarea name="description" id="editProductDescription" class="form-control"><?php echo e($product->Description ?? ''); ?></textarea>
</div>

<div class="col-12">
    <label>Specifications</label>
    <textarea name="specifications" id="editProductSpecifications" class="form-control"><?php echo e($product->specifications ?? ''); ?></textarea>
</div>


<div class="col-md-6">
  <label>Warranty</label>
  <input type="text" name="warranty" id="edit-warranty" class="form-control" value="<?php echo e($product->warranty ?? ''); ?>">
</div>

<div class="col-md-6">
  <label>Thumbnail</label>
  <input type="file" name="thumbnail" class="form-control" accept="image/*">
</div>

<div class="col-md-12">
  <label>Gallery Images</label>
  <input type="file" name="gallery_images[]" multiple class="form-control" accept="image/*">
</div>

<!-- CKEditor 5 CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

<script>
let editSpecificationsEditor = null;

document.addEventListener('DOMContentLoaded', function () {
    const editModal = document.getElementById('editProductModal');

    if (editModal) {
        editModal.addEventListener('shown.bs.modal', function () {
            const specsEl = document.querySelector('#editProductSpecifications');
            if (!specsEl) return;

            // Destroy existing CKEditor instance if any
            if (editSpecificationsEditor) {
                editSpecificationsEditor.destroy()
                    .then(() => initEditSpecificationsEditor(specsEl))
                    .catch(error => console.error('Destroy error:', error));
            } else {
                initEditSpecificationsEditor(specsEl);
            }
        });
    }
});

function initEditSpecificationsEditor(element) {
    ClassicEditor
        .create(element)
        .then(editor => {
            editSpecificationsEditor = editor;
        })
        .catch(error => {
            console.error('CKEditor create error:', error);
        });
}
</script>

<script>
$(document).ready(function () {
  // Initialize global flag if not exists
  if (typeof window.isSlugManuallyEdited === 'undefined') {
    window.isSlugManuallyEdited = false;
  }

  // Track if user manually edits the slug
  $('#edit-slug').on('input', function () {
    window.isSlugManuallyEdited = true;
  });

  // Auto-generate slug when typing the name
  $('#edit-name').on('input', function () {
    if (!window.isSlugManuallyEdited) {
      let name = $(this).val();
      let slug = name
        .toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '')  // remove special chars
        .replace(/\s+/g, '-')          // replace spaces with -
        .replace(/-+/g, '-')           // collapse multiple -
        .trim();

      $('#edit-slug').val(slug);
    }
  });

  // Reset flag when modal is opened
  $('#editProductModal').on('show.bs.modal', function () {
    window.isSlugManuallyEdited = false;
  });
});
</script>




<?php /**PATH C:\xampp\htdocs\my_tecmou_solution\backend\resources\views/admin/products/partials/edit-product-modal.blade.php ENDPATH**/ ?>