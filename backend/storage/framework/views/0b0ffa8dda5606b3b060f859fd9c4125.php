<style>
    .ck-editor__editable_inline {
        min-height:150px;
    }
</style>

<input type="hidden" name="id" id="edit-brand-id" value="<?php echo e($brand->id ?? ''); ?>">

<div class="col-md-6">
    <label for="category_id">Category</label>
    <select name="category_id" class="form-control" required>
        <option value="">Select Category</option>
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($category->id); ?>"
                <?php echo e((isset($brand) && $brand->category_id == $category->id) ? 'selected' : ''); ?>>
                <?php echo e($category->name); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>

<div class="col-md-6">
    <label>Name</label>
    <input type="text" name="name" id="edit-brand-name" class="form-control" value="<?php echo e($brand->name ?? ''); ?>" required>
</div>

<div class="col-md-6">
    <label>Slug</label>
    <input type="text" name="slug" id="edit-brand-slug" class="form-control" value="<?php echo e($brand->slug ?? ''); ?>">
</div>
<div class="col-md-6">
    <label>Website</label>
    <input type="url" name="website" id="edit-brand-website" class="form-control" value="<?php echo e($brand->website ?? ''); ?>">
</div>
<div class="col-12">
    <label>Description</label>
    <textarea name="description" id="edit-brand-description" class="form-control">
        <?php echo e($brand->description ?? ''); ?>

    </textarea>
</div>

<div class="mb-3">
    <label for="status" class="form-label">Status</label>
    <select name="status" id="edit-brand-status" class="form-control" required>
        <option value="1" <?php echo e(isset($brand) && $brand->status == 1 ? 'selected' : ''); ?>>Active</option>
        <option value="0" <?php echo e(isset($brand) && $brand->status == 0 ? 'selected' : ''); ?>>Inactive</option>
    </select>
</div>

<div class="col-md-6">
    <label>Logo</label>
 <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="file" name="image" class="form-control" accept="image/*">
            <small class="form-text text-muted">Max file size: 2MB. Supported formats: JPG, PNG, GIF</small>
          </div>
        <img id="editBrandLogoPreview" src="<?php echo e(isset($brand) && $brand->logo ? asset('storage/' . $brand->logo) : '#'); ?>"
        class="mt-2 <?php echo e(isset($brand) && $brand->logo ? '' : 'd-none'); ?> border rounded" width="60" height="60">
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
    let editBrandEditor;

    function initEditBrandEditor() {
        const el = document.querySelector('#edit-brand-description');
        if (el) {
            // If already initialized, destroy and recreate
            if (editBrandEditor) {
                editBrandEditor.destroy()
                    .then(() => {
                        ClassicEditor.create(el)
                            .then(editor => {
                                editBrandEditor = editor;
                            });
                    });
            } else {
                ClassicEditor.create(el)
                    .then(editor => {
                        editBrandEditor = editor;
                    })
                    .catch(error => {
                        console.error('CKEditor error:', error);
                    });
            }
        }
    }

    // Trigger CKEditor initialization every time the edit modal is shown
    document.addEventListener('DOMContentLoaded', function () {
        $('#editBrandModal').on('shown.bs.modal', function () {
            initEditBrandEditor();
        });
    });
</script>

<script>
    // Create or Refresh CKEditor for "Edit Modal"
    function initEditEditor() {
        const el = document.querySelector('#editDescriptionEditor');
        if (el) {
            if (editEditorInstance) {
                // Destroy and recreate to avoid duplication
                editEditorInstance.destroy()
                    .then(() => {
                        ClassicEditor.create(el)
                            .then(editor => {
                                editEditorInstance = editor;
                            });
                    });
            } else {
                ClassicEditor
                    .create(el)
                    .then(editor => {
                        editEditorInstance = editor;
                    })
                    .catch(error => {
                        console.error('Edit CKEditor error:', error);
                    });
            }
        }
    }
    // Run on page ready
    document.addEventListener("DOMContentLoaded", function () {
        // Init Create CKEditor immediately
        initCreateEditor();

        // Init/Edit CKEditor every time edit modal opens
        $('#editCategoryModal').on('shown.bs.modal', function () {
            initEditEditor();
        });
    });
</script>
<script>
    // Auto-generate slug from name
    $(document).on('input', '#edit-brand-name', function () {
        const nameValue = this.value;
        const slug = nameValue
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');

        $('#edit-brand-slug').val(slug);
    });

    // Preview logo image
    $(document).on('change', '#edit-brand-logo', function () {
        const preview = document.getElementById('editBrandLogoPreview');
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                preview.style.display = 'block';
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
</script><?php /**PATH C:\xampp\htdocs\my_tecmou_solution\backend\resources\views/admin/brands/partials/edit-brand-modal.blade.php ENDPATH**/ ?>