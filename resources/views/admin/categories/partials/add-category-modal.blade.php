<style>
/* Optional: improve the toggle UI */
.form-check-input {
    cursor: pointer;
    transform: scale(1.2);
    
}
.ck-editor__editable_inline {
        min-height: 300px;
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
        {{ old('description', $category->description ?? '') }}
    </textarea>
</div>
<div class="mb-3">
  <label for="image" class="form-label">Image</label>
  <input type="file" name="image" class="form-control">
</div>

<div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-control @error('status') is-invalid @enderror">
        <option value="1" {{ old('status', $brand->status ?? 1) == 1 ? 'selected' : '' }}>Active</option>
        <option value="0" {{ old('status', $brand->status ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
    </select>
    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<<<<<<< HEAD
=======

>>>>>>> 1d06d67caf76ba69fa6956adbc311bec1a33c04d
<div class="mb-3">
  <label for="parent_id" class="form-label">Parent Category</label>
  <select name="parent_id" class="form-control">
    <option value="">None</option>
    @foreach ($categories as $cat)
      <option value="{{ $cat->id }}">{{ $cat->name }}</option>
    @endforeach
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
