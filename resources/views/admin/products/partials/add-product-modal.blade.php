<!-- Display validation errors -->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<style>
    .ck-editor__editable_inline {
        min-height: 300px;
    }
</style>


<div class="mb-3">
    <label class="form-label">Name <span class="text-danger">*</span></label>
    <input type="text" name="name" id="edit-name" value="{{ old('name') }}"
           class="form-control @error('name') is-invalid @enderror" required>
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Slug <span class="text-danger">*</span></label>
    <input type="text" name="slug" id="edit-slug" value="{{ old('slug') }}"
           class="form-control @error('slug') is-invalid @enderror" required>
    @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">SKU</label>
    <input type="text" name="sku" value="{{ old('sku') }}"
           class="form-control @error('sku') is-invalid @enderror">
    @error('sku') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Category <span class="text-danger">*</span></label>
    <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
        <option value="">-- Select Category --</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
            </option>
        @endforeach
    </select>
    @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Brand <span class="text-danger">*</span></label>
    <select name="brand_id" class="form-control @error('brand_id') is-invalid @enderror" required>
        <option value="">-- Select Brand --</option>
        @foreach($brands as $brand)
            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                {{ $brand->name }}
            </option>
        @endforeach
    </select>
    @error('brand_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Model</label>
    <input type="text" name="model" value="{{ old('model') }}"
           class="form-control @error('model') is-invalid @enderror">
    @error('model') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <!-- Create Product Modal -->
<div class="col-12">
    <label>Description</label>
    <textarea name="description" id="createProductDescription" class="form-control">{{ old('description') }}</textarea>
    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Specifications</label>
    <textarea name="specifications" class="form-control @error('specifications') is-invalid @enderror" rows="3">{{ old('specifications') }}</textarea>
    @error('specifications') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Price</label>
    <input type="number" name="price" value="{{ old('price') }}"
           class="form-control @error('price') is-invalid @enderror" step="0.01" min="0">
    @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Discount (%)</label>
    <input type="number" name="discount" value="{{ old('discount') }}"
           class="form-control @error('discount') is-invalid @enderror" step="0.01" min="0" max="100">
    @error('discount') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Stock Quantity</label>
    <input type="number" name="stock_quantity" value="{{ old('stock_quantity') }}"
           class="form-control @error('stock_quantity') is-invalid @enderror" min="0">
    @error('stock_quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Warranty</label>
    <input type="text" name="warranty" value="{{ old('warranty') }}"
           class="form-control @error('warranty') is-invalid @enderror">
    @error('warranty') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-control @error('status') is-invalid @enderror">
        <option value="1" {{ old('status', $brand->status ?? 1) == 1 ? 'selected' : '' }}>Active</option>
        <option value="0" {{ old('status', $brand->status ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
    </select>
    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>


<div class="mb-3">
    <label class="form-label">Is Featured?</label>
    <select name="is_featured" class="form-control @error('is_featured') is-invalid @enderror">
        <option value="0" {{ old('is_featured') == '0' ? 'selected' : '' }}>No</option>
        <option value="1" {{ old('is_featured') == '1' ? 'selected' : '' }}>Yes</option>
    </select>
    @error('is_featured') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Thumbnail</label>
    <input type="file" name="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror" accept="image/*">
    @error('thumbnail') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Gallery Images</label>
    <input type="file" name="gallery_images[]" multiple class="form-control @error('gallery_images') is-invalid @enderror" accept="image/*">
    @error('gallery_images') <div class="invalid-feedback">{{ $message }}</div> @enderror
    @error('gallery_images.*') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<!-- CKEditor CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

<script>
    let createProductEditor = null;
    let editProductEditor = null;

    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Create CKEditor
        const createEl = document.querySelector('#createProductDescription');
        if (createEl) {
            ClassicEditor
                .create(createEl)
                .then(editor => {
                    createProductEditor = editor;
                })
                .catch(error => console.error(error));
        }

        // Initialize Edit CKEditor only when modal is opened
        const editModal = document.getElementById('editProductModal');
        if (editModal) {
            editModal.addEventListener('shown.bs.modal', function () {
                const editEl = document.querySelector('#editProductDescription');

                // Destroy old editor if exists
                if (editProductEditor) {
                    editProductEditor.destroy()
                        .then(() => {
                            initEditProductEditor(editEl);
                        })
                        .catch(error => console.error(error));
                } else {
                    initEditProductEditor(editEl);
                }
            });
        }
    });

    function initEditProductEditor(element) {
        ClassicEditor
            .create(element)
            .then(editor => {
                editProductEditor = editor;
            })
            .catch(error => {
                console.error(error);
            });
    }
</script>

<script>
  $(document).ready(function () {
    $('#edit-name').on('input', function () {
      let name = $(this).val();
      let slug = name
        .toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '')  // remove special chars
        .replace(/\s+/g, '-')          // replace spaces with -
        .replace(/-+/g, '-')           // collapse multiple -
        .trim();

      $('#edit-slug').val(slug);
    });
  });
</script>

