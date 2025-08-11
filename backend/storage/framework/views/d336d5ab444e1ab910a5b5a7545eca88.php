<div class="mb-3">
  <label>Name</label>
  <input type="text" name="name" class="form-control" required>
</div>

<div class="mb-3">
  <label>Slug</label>
  <input type="text" name="slug" class="form-control">
</div>
 <div class="modal-body">
          <div class="mb-3">
            <label>Main Category</label>
            <select name="category_id" class="form-control" required>
              <option value="">Select Main Category</option>
              <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($cat->id); ?>"><?php echo e($cat->name); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>

<div class="col-12">
    <label>Description</label>
    <textarea name="description" id="descriptionEditor" class="form-control"></textarea>
</div>

 <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="file" name="image" class="form-control" accept="image/*">
            <small class="form-text text-muted">Max file size: 2MB. Supported formats: JPG, PNG, GIF</small>
          </div>

<div class="mb-3">
  <label>Status</label>
  <select name="status" class="form-control">
    <option value="1">Active</option>
    <option value="0">Inactive</option>
  </select>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
ClassicEditor.create(document.querySelector('#descriptionEditor')).catch(console.error);
</script>
<?php /**PATH C:\xampp\htdocs\my_tecmou_solution\backend\resources\views/admin/subcategories/partials/add-subcategory-modal.blade.php ENDPATH**/ ?>