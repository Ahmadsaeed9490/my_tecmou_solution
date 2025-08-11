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
            <select name="category_id" id="edit-category-id" class="form-control" required>
              <option value="">Select Main Category</option>
              <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($cat->id); ?>"><?php echo e($cat->name); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>

<div class="col-12">
    <label>Description</label>
    <textarea name="description" id="editDescriptionEditor" class="form-control"></textarea>
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

<script>
let editSubCategoryEditor;
function initEditSubCategoryEditor() {
    if (editSubCategoryEditor) {
        editSubCategoryEditor.destroy().then(() => {
            ClassicEditor.create(document.querySelector('#editDescriptionEditor'))
                .then(editor => { editSubCategoryEditor = editor; });
        });
    } else {
        ClassicEditor.create(document.querySelector('#editDescriptionEditor'))
            .then(editor => { editSubCategoryEditor = editor; });
    }
}

$('#edit_subcategory_Modal').on('shown.bs.modal', function () {
    initEditSubCategoryEditor();
});
</script>
<?php /**PATH C:\xampp\htdocs\my_tecmou_solution\backend\resources\views/admin/subcategories/partials/edit-subcategory-modal.blade.php ENDPATH**/ ?>