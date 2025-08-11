<style>
    /* Optional: improve the toggle UI */
    .form-check-input {
        cursor: pointer;
        transform: scale(1.2);
    }

    .ck-editor__editable_inline {
        min-height: 150px;
        /* Adjust as needed */
    }
</style>
  <div class="col-md-6">
            <label for="category_id">Category</label>
            <select name="category_id" class="form-control" required>
                <option value="">Select Category</option>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
<div class="col-md-6">
    <label>Name</label>
    <input type="text" name="name" class="form-control" required>
</div>
<div class="col-md-6">
    <label>Slug</label>
    <input type="text" name="slug" class="form-control">
</div>
<div class="col-md-6">
    <label>Website</label>
    <input type="url" name="website" class="form-control">
</div>
<div class="col-12">
    <label>Description</label>
    <textarea name="description" id="descriptionEditor"
        class="form-control"><?php echo e(old('description', $brand->description)); ?></textarea>
</div>

<div class="col-md-6">
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

<div class="col-md-6">
    <label>Logo</label>
    <input type="file" name="logo" class="form-control" accept="image/*" onchange="previewLogo(this)">
    <img id="logoPreview" src="#" class="mt-2 d-none border rounded" width="60" height="60">
</div>
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#descriptionEditor'))
        .catch(error => {
            console.error(error);
        });
</script>
<script>
    function previewLogo(input) {
        const preview = document.getElementById('logoPreview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<script>
    // Auto-generate slug from name
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
</script><?php /**PATH C:\xampp\htdocs\my_tecmou_solution\backend\resources\views/admin/brands/partials/add-brand-modal.blade.php ENDPATH**/ ?>