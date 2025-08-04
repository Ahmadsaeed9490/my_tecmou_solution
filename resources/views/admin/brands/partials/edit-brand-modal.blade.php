<div class="row g-3">
    <div class="col-md-6">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="{{ $brand->name ?? '' }}" required>
    </div>

    <div class="col-md-6">
        <label>Slug</label>
        <input type="text" name="slug" class="form-control" value="{{ $brand->slug ?? '' }}">
    </div>

    <div class="col-12">
        <label>Description</label>
        <textarea name="description" class="form-control" rows="3">{{ $brand->description ?? '' }}</textarea>
    </div>

    <div class="col-md-6">
        <label>Website</label>
        <input type="url" name="website" class="form-control" value="{{ $brand->website ?? '' }}">
    </div>

    <div class="col-md-6">
        <label>Sort Order</label>
        <input type="number" name="sort_order" class="form-control" value="{{ $brand->sort_order ?? 0 }}">
    </div>

    <div class="col-md-6">
        <label>Status</label>
        <select name="status" class="form-control" required>
            <option value="1" {{ isset($brand) && $brand->status == 1 ? 'selected' : '' }}>Active</option>
            <option value="0" {{ isset($brand) && $brand->status == 0 ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>

    <div class="col-md-6">
        <label>Logo</label>
        <input type="file" name="logo" class="form-control" accept="image/*">
        @if (!empty($brand->logo))
            <div class="mt-2">
                <img src="{{ asset('storage/' . $brand->logo) }}" class="border rounded" width="60" height="60" alt="Logo Preview">
                <small class="d-block mt-1">Current Logo</small>
            </div>
        @endif
    </div>
</div>

{{-- Auto-generate slug --}}
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