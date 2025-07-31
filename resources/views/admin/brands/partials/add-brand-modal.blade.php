
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
        <img id="logoPreview"
             src="{{ $brand->logo ? asset('storage/' . $brand->logo) : '#' }}"
             class="mt-2 {{ $brand->logo ? '' : 'd-none' }} border rounded"
             width="60" height="60">
    </div>
</div>
</script>

<script>
    // For Create Modal
    document.getElementById('nameInput')?.addEventListener('input', function () {
        const slug = this.value.toLowerCase()
            .trim()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
        document.getElementById('slugInput').value = slug;
    });

    function previewLogo(input) {
        const preview = document.getElementById('logoPreview') || document.getElementById('editBrandLogoPreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>


