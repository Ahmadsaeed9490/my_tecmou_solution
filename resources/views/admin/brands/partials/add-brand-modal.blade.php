
<div class="row g-3">
    <div class="col-md-6">
        <label>Name</label>
        <input type="text" name="name" id="nameInput" class="form-control" value="{{ old('name', $brand->name) }}" required>
    </div>

    <div class="col-md-6">
        <label>Slug</label>
        <input type="text" name="slug" id="slugInput" class="form-control" value="{{ old('slug', $brand->slug) }}">
    </div>

    <div class="col-12">
        <label>Description</label>
        <textarea name="description" class="form-control" rows="3">{{ old('description', $brand->description) }}</textarea>
    </div>

    <div class="col-md-6">
        <label>Website</label>
        <input type="url" name="website" class="form-control" value="{{ old('website', $brand->website) }}">
    </div>

    <div class="col-md-6">
        <label>Sort Order</label>
        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $brand->sort_order ?? 0) }}">
    </div>

    <div class="col-md-6">
        <label>Status</label>
        <select name="status" class="form-control" required>
            <option value="1" {{ old('status', $brand->status) == 1 ? 'selected' : '' }}>Active</option>
            <option value="0" {{ old('status', $brand->status) == 0 ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>

<div class="col-md-6">
    <label>Logo</label>
    <input type="file" name="logo" class="form-control" accept="image/*" onchange="previewLogo(this)">
    <img id="logoPreview" src="#" class="mt-2 d-none border rounded" width="60" height="60">
</div>

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

    // Auto-generate slug from name
    document.querySelector('input[name="name"]').addEventListener('input', function () {
        const nameValue = this.value;
        const slug = nameValue
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9\s-]/g, '')  // Remove special chars
            .replace(/\s+/g, '-')          // Replace spaces with hyphens
            .replace(/-+/g, '-');          // Remove multiple hyphens

        document.querySelector('input[name="slug"]').value = slug;
    });
</script>