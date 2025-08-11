<style>
    .ck-editor__editable_inline {
        min-height: 150px;
    }
</style>
<div class="mb-3">
  <label for="name" class="form-label">Name</label>
  <input type="text" name="name" class="form-control" value="<?php echo e($category->name ?? ''); ?>" required>
</div>
<div class="mb-3">
  <label for="slug" class="form-label">Slug</label>
  <input type="text" name="slug" class="form-control" value="<?php echo e($category->slug ?? ''); ?>">
</div>
<div class="col-12">
    <label>Description</label>
    <textarea name="description" id="edit-brand-description" class="form-control"><?php echo e($category->description ?? ''); ?></textarea>
</div>
<div class="mb-3">
 <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="file" name="image" class="form-control" accept="image/*">
            <small class="form-text text-muted">Max file size: 2MB. Supported formats: JPG, PNG, GIF</small>
          </div>  <input type="file" name="image" class="form-control">

  <?php if(!empty($category->image)): ?>
    <div class="mt-2">
      <small>Current Image:</small><br>

      
    <?php if(!empty($category->image)): ?>
  <div class="mt-2">
    <small>Current Image:</small><br>

    <?php
      $imagePath = Str::startsWith($category->image, 'categories/') 
                    ? asset('storage/' . $category->image) 
                    : asset('uploads/categories/' . $category->image);
    ?>

    <img src="<?php echo e($imagePath); ?>" 
         alt="Category Image" 
         style="max-width: 150px; height: auto; border: 1px solid #ddd; padding: 3px;">
  </div>
<?php endif; ?>

    </div>
  <?php endif; ?>
</div>


<div class="mb-3">
  <label for="status" class="form-label">Status</label>
  <select name="status" class="form-control">
    <option value="1" <?php echo e((isset($category) && $category->status == 1) ? 'selected' : ''); ?>>Active</option>
    <option value="0" <?php echo e((isset($category) && $category->status == 0) ? 'selected' : ''); ?>>Inactive</option>
  </select>
</div>
<div class="mb-3">
  <label for="parent_id" class="form-label">Parent Category</label>
  <select name="parent_id" class="form-control">
    <option value="">None</option>
    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <option value="<?php echo e($cat->id); ?>" 
        <?php echo e((isset($category) && $category->parent_id == $cat->id) ? 'selected' : ''); ?>>
        <?php echo e($cat->name); ?>

      </option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </select>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
    let editCategoryEditor;

    function initEditCategoryEditor() {
        const el = document.querySelector('#edit-brand-description');
        if (el) {
            if (editCategoryEditor) {
                editCategoryEditor.destroy().then(() => {
                    ClassicEditor.create(el).then(editor => {
                        editCategoryEditor = editor;
                    });
                });
            } else {
                ClassicEditor.create(el).then(editor => {
                    editCategoryEditor = editor;
                }).catch(error => {
                    console.error('CKEditor error:', error);
                });
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        $('#edit_category_Modal').on('shown.bs.modal', function () {
            initEditCategoryEditor(); // ✅ Corrected function name
        });
    });
</script>

<script>
  $(document).ready(function () {
    $('input[name="name"]').on('input', function () {
      let name = $(this).val();
      let slug = name
        .toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim();
      $('input[name="slug"]').val(slug);
    });
  });
</script> 
<?php /**PATH C:\xampp\htdocs\my_tecmou_solution\backend\resources\views/admin/categories/partials/edit-category-modal.blade.php ENDPATH**/ ?>