<div class="col-md-6">
    <label>Name</label>
    <input type="text" name="name" id="nameInput" class="form-control" value="{{ $brand->name ?? '' }}" required>
</div>

<div class="col-md-6">
    <label>Slug</label>
    <input type="text" name="slug" id="slugInput" class="form-control" value="{{ $brand->slug ?? '' }}">
</div>

<div class="col-12">
    <label>Description</label>
    <textarea name="description" class="form-control">{{ $brand->description ?? '' }}</textarea>
</div>

<div class="col-md-6">
    <label>Website</label>
    <input type="url" name="website" class="form-control" value="{{ $brand->website ?? '' }}">
</div>

<div class="col-md-6">
    <label>Sort Order</label>
    <input type="number" name="sort_order" class="form-control" value="{{ $brand->sort_order ?? 0 }}">
</div>

<select name="status" class="form-select">
    <option value="1" {{ (isset($brand) && $brand->status == 1) ? 'selected' : '' }}>Active</option>
    <option value="0" {{ (isset($brand) && $brand->status == 0) ? 'selected' : '' }}>Inactive</option>
</select>


<div class="col-md-6">
    <label>Logo</label>
    <input type="file" name="logo" class="form-control" accept="image/*" onchange="previewLogo(this)">

    {{-- Preview image --}}
    <img 
        id="logoPreview"
        src="{{ !empty($brand->logo) ? asset('storage/' . $brand->logo) : '#' }}"
        class="mt-2 border rounded {{ empty($brand->logo) ? 'd-none' : '' }}"
        width="60"
        height="60"
    >
</div>

<script>
    function previewLogo(input) {
        const preview = document.getElementById('logoPreview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<script>
    // Preview image
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
    document.getElementById('nameInput').addEventListener('input', function () {
        let slug = this.value
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9\s-]/g, '')  // Remove special chars
            .replace(/\s+/g, '-')          // Replace spaces with -
            .replace(/-+/g, '-');          // Replace multiple - with one

        document.getElementById('slugInput').value = slug;
    });
</script>

