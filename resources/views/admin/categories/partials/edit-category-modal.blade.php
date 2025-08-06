<style>
    .ck-editor__editable_inline {
        min-height: 300px;
    }
</style>

<div class="mb-3">
  <label for="name" class="form-label">Name</label>
  <input type="text" name="name" class="form-control" value="{{ $category->name ?? '' }}" required>
</div>

<div class="mb-3">
  <label for="slug" class="form-label">Slug</label>
  <input type="text" name="slug" class="form-control" value="{{ $category->slug ?? '' }}">
</div>

<div class="col-12">
    <label>Description</label>
    <textarea name="description" id="edit-brand-description" class="form-control">{{ $brand->description ?? '' }}</textarea>
</div>

<div class="mb-3">
  <label for="image" class="form-label">Image</label>
  <input type="file" name="image" class="form-control">
  @if (!empty($category->image))
    <small>Current Image: {{ $category->image }}</small>
  @endif
</div>

<div class="mb-3">
  <label for="status" class="form-label">Status</label>
  <select name="status" class="form-control">
    <option value="1" {{ (isset($category) && $category->status == 1) ? 'selected' : '' }}>Active</option>
    <option value="0" {{ (isset($category) && $category->status == 0) ? 'selected' : '' }}>Inactive</option>
  </select>
</div>


<div class="mb-3">
  <label for="parent_id" class="form-label">Parent Category</label>
  <select name="parent_id" class="form-control">
    <option value="">None</option>
    @foreach ($categories as $cat)
      <option value="{{ $cat->id }}" {{ (isset($category) && $category->parent_id == $cat->id) ? 'selected' : '' }}
        {{ $cat->name }}>
      </option>
    @endforeach
  </select>
</div>
<!-- CKEditor 5 CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
    let editBrandEditor;

    function initEditBrandEditor() {
        const el = document.querySelector('#edit-brand-description');

        if (el) {
            if (editBrandEditor) {
                editBrandEditor.destroy().then(() => {
                    ClassicEditor.create(el).then(editor => {
                        editBrandEditor = editor;
                    });
                });
            } else {
                ClassicEditor.create(el).then(editor => {
                    editBrandEditor = editor;
                }).catch(error => {
                    console.error('CKEditor error:', error);
                });
            }
        }
    }

    // When edit modal opens
    document.addEventListener('DOMContentLoaded', function () {
        $('#editBrandModal').on('shown.bs.modal', function () {
            initEditBrandEditor();
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
