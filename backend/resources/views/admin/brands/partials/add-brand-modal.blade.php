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
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
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
        class="form-control">{{ old('description', $brand->description) }}</textarea>
</div>

<div class="row">
    <div class="col-md-6">
        <label for="status" class="form-label">Status</label>
        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
            <option value="1" {{ old('status', $brand->status ?? 1) == 1 ? 'selected' : '' }}>Active</option>
            <option value="0" {{ old('status', $brand->status ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
        </select>
        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="logo" class="form-label">Logo</label>
        <input type="file" name="logo" id="logo" class="form-control @error('logo') is-invalid @enderror" accept="image/*" onchange="previewLogo(this)">
        @error('logo')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        @if(isset($brand->logo))
            <img src="{{ asset('storage/' . $brand->logo) }}" class="mt-2 border rounded" width="60" height="60">
        @else
            <img id="logoPreview" src="#" class="mt-2 d-none border rounded" width="60" height="60">
        @endif
    </div>
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
</script>