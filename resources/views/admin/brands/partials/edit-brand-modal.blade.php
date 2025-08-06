<style>
    .ck-editor__editable_inline {
        min-height: 300px;
    }
</style>

<input type="hidden" name="id" id="edit-brand-id" value="{{ $brand->id ?? '' }}">

<div class="col-md-6">
    <label>Name</label>
    <input type="text" name="name" id="edit-brand-name" class="form-control" value="{{ $brand->name ?? '' }}" required>
</div>

<div class="col-md-6">
    <label>Slug</label>
    <input type="text" name="slug" id="edit-brand-slug" class="form-control" value="{{ $brand->slug ?? '' }}">
</div>

<!-- Edit Modal -->
<div class="col-12">
    <label>Description</label>
    <textarea name="description" id="editDescriptionEditor" class="form-control">{{ old('description') }}</textarea>
</div>


<div class="col-md-6">
    <label>Website</label>
    <input type="url" name="website" id="edit-brand-website" class="form-control" value="{{ $brand->website ?? '' }}">
</div>

<div class="mb-3">
    <label for="status" class="form-label">Status</label>
    <select name="status" id="edit-brand-status" class="form-control" required>
        <option value="1" {{ isset($brand) && $brand->status == 1 ? 'selected' : '' }}>Active</option>
        <option value="0" {{ isset($brand) && $brand->status == 0 ? 'selected' : '' }}>Inactive</option>
    </select>
</div>

<div class="col-md-6">
    <label>Logo</label>
    <input type="file" name="logo" id="edit-brand-logo" class="form-control" accept="image/*">
    <img id="editBrandLogoPreview"
         src="{{ isset($brand) && $brand->logo ? asset('storage/' . $brand->logo) : '#' }}"
         class="mt-2 {{ isset($brand) && $brand->logo ? '' : 'd-none' }} border rounded"
         width="60" height="60">
</div>
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
let editEditorInstance = null;

document.addEventListener('DOMContentLoaded', function () {
    const editModal = document.getElementById('editBrandModal');

    editModal.addEventListener('shown.bs.modal', function () {
        const editorElement = document.querySelector('#editDescriptionEditor');

        // Destroy previous instance (if already exists)
        if (editEditorInstance) {
            editEditorInstance.destroy()
                .then(() => {
                    createEditEditor(editorElement);
                })
                .catch(error => console.error(error));
        } else {
            createEditEditor(editorElement);
        }
    });
});

function createEditEditor(editorElement) {
    ClassicEditor
        .create(editorElement)
        .then(editor => {
            editEditorInstance = editor;
        })
        .catch(error => {
            console.error(error);
        });
}
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
</script>