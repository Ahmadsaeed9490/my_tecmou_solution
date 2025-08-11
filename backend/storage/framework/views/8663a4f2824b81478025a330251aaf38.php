<style>
/* Optional: improve the toggle UI */
.form-check-input {
    cursor: pointer;
    transform: scale(1.2);
    
}
.ck-editor__editable_inline {
        min-height: 150px;
}
</style>

<div class="mb-3">
  <label for="name" class="form-label">Name</label>
  <input type="text" name="name" class="form-control" required>
</div>

<div class="mb-3">
  <label for="slug" class="form-label">Slug</label>
  <input type="text" name="slug" class="form-control">
</div>

<div class="col-12">
    <label>Description</label>
    <textarea name="description" id="descriptionEditor" class="form-control">
        <?php echo e(old('description', $category->description ?? '')); ?>

    </textarea>
</div>
 <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="file" name="image" class="form-control" accept="image/*">
            <small class="form-text text-muted">Max file size: 2MB. Supported formats: JPG, PNG, GIF</small>
          </div>

<div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-control <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
        <option value="1" <?php echo e(old('status', $brand->status ?? 1) == 1 ? 'selected' : ''); ?>>Active</option>
        <option value="0" <?php echo e(old('status', $brand->status ?? 1) == 0 ? 'selected' : ''); ?>>Inactive</option>
    </select>
    <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

  </div>

<div class="mb-3">
  <label for="parent_id" class="form-label">Parent Category</label>
  <select name="parent_id" class="form-control">
    <option value="">None</option>
    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <option value="<?php echo e($cat->id); ?>"><?php echo e($cat->name); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </select>
</div>
<!-- CKEditor 5 CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#descriptionEditor'))
        .catch(error => {
            console.error(error);
        });
</script>

<script>
  $(document).ready(function () {
    $('input[name="name"]').on('input', function () {
      let name = $(this).val();
      let slug = name
        .toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '') // remove non-alphanumeric chars
        .replace(/\s+/g, '-')         // replace spaces with -
        .replace(/-+/g, '-')          // remove multiple -
        .trim();

      $('input[name="slug"]').val(slug);
    });
  });
</script>
<?php /**PATH C:\xampp\htdocs\my_tecmou_solution\backend\resources\views/admin/categories/partials/add-category-modal.blade.php ENDPATH**/ ?>