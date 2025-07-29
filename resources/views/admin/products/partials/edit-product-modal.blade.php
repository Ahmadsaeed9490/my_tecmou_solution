<input type="hidden" name="id" id="edit-id">

        <div class="col-md-6">
  <label>Name</label>
  <input type="text" name="name" id="edit-name" class="form-control">
</div>

<div class="col-md-6">
  <label>Slug</label>
  <input type="text" name="slug" id="edit-slug" class="form-control">
</div>

          <div class="col-md-6">
            <label>Category</label>
            <select name="category_id" id="edit-category" class="form-select">
              @foreach ($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-md-6">
            <label>Brand</label>
            <select name="brand_id" id="edit-brand" class="form-select">
              @foreach ($brands as $brand)
                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
              @endforeach
            </select>
          </div>
          <select name="status" id="edit-status" class="form-select">
  <option value="1" {{ old('status', $product->status ?? 1) == 1 ? 'selected' : '' }}>Active</option>
  <option value="0" {{ old('status', $product->status ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
</select>



          <div class="col-md-6">
            <label>Is Featured?</label>
            <select name="is_featured" id="edit-featured" class="form-select">
              <option value="0">No</option>
              <option value="1">Yes</option>
            </select>
          </div>

          <div class="col-md-12">
            <label>Description</label>
            <textarea name="description" id="edit-description" class="form-control"></textarea>
          </div>
        <script>
          $(document).ready(function () {
            $('#edit-name').on('input', function () {
              let name = $(this).val();
              let slug = name
                .toLowerCase()
                .trim()
                .replace(/[^a-z0-9\s-]/g, '')  // Remove special chars
                .replace(/\s+/g, '-')          // Replace spaces with -
                .replace(/-+/g, '-');          // Replace multiple - with single -

              $('#edit-slug').val(slug);
            });
          });
        </script>

