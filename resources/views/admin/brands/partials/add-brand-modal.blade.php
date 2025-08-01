<div class="col-md-6">
    <label>Name</label>
    <input type="text" name="name" class="form-control" required>
</div>
<div class="col-md-6">
    <label>Slug</label>
    <input type="text" name="slug" class="form-control">
</div>
<div class="col-12">
    <label>Description</label>
    <textarea name="description" class="form-control"></textarea>
</div>
<div class="col-md-6">
    <label>Website</label>
    <input type="url" name="website" class="form-control">
</div>
<div class="col-md-6">
    <label>Sort Order</label>
    <input type="number" name="sort_order" class="form-control" value="0">
</div>
<div class="mb-3">
  <label for="status" class="form-label">Status</label>
  <select name="status" class="form-control" required>
    <option value="1">Active</option>
    <option value="0">Inactive</option>
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


