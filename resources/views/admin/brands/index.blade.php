@extends('layout.master')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>All Brands</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createBrandModal">Add Brand</button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive bg-white p-3 rounded shadow-sm">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Logo</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Website</th>
                    <th>Status</th>
                    <th>Sort Order</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($brands as $brand)
                <tr>
                      <td>{{ $brand->id }}</td>
                    <td>
                        @if($brand->logo)
                            <img src="{{ asset('storage/' . $brand->logo) }}" alt="Logo" width="40" height="40">
                        @else
                            <span class="text-muted">No Logo</span>
                        @endif
                    </td>
                    <td>{{ $brand->name }}</td>
                    <td>{{ $brand->slug }}</td>
                    <td><a href="{{ $brand->website }}" target="_blank">{{ $brand->website }}</a></td>
                        <td>
                                @if ($brand->deleted_at)
                                    <span class="badge bg-secondary">Deleted</span>
                                @else
                                    <div class="form-check form-switch">
                                        <input type="checkbox"
                                            class="form-check-input toggle-status"
                                            data-id="{{ $brand->id }}"
                                            {{ $brand->status ? 'checked' : '' }}>
                                        <label class="form-check-label ms-2">
                                            <span class="badge status-badge bg-{{ $brand->status ? 'success' : 'danger' }}">
                                                {{ $brand->status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </label>
                                    </div>
                                @endif
                            </td>

                    <td>{{ $brand->sort_order }}</td>
                    <td>
                        <button class="btn btn-sm btn-info editBrandBtn" data-id="{{ $brand->id }}" data-bs-toggle="modal" data-bs-target="#editBrandModal">Edit</button>
                        <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createBrandModal" tabindex="-1" aria-labelledby="createBrandModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Add New Brand</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body row g-3">
       @include('admin.brands.partials.add-brand-modal')
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Create Brand</button>
      </div>
    </form>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editBrandModal" tabindex="-1" aria-labelledby="editBrandModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
<form id="editBrandForm" method="POST" enctype="multipart/form-data" class="modal-content">
    @csrf
    @method('PUT')

      <!-- The form will be populated via AJAX -->
      <div class="modal-header">
        <h5 class="modal-title">Edit Brand</h5>
<button class="btn btn-sm btn-primary btnEditBrand" data-id="{{ $brand->id }}">Edit</button>
      </div>
      <div class="modal-body row g-3">
     @include('admin.brands.partials.edit-brand-modal')
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update Brand</button>
      </div>
        <input type="hidden" name="id" id="editBrandId">
    </form>
  

  </div>
</div>
@endsection
@push('scripts')
<script>
$(document).ready(function () {
    // Edit button click
    $('.editBrandBtn').on('click', function () {
        const id = $(this).data('id');

        // Send AJAX GET request to fetch brand details
        $.ajax({
            url: '/admin/brands/' + brandId + '/edit',
            type: 'GET',
            success: function (brand) {
                // Set values in modal inputs
                $('#editBrandForm input[name="name"]').val(brand.name);
                $('#editBrandForm input[name="slug"]').val(brand.slug);
                $('#editBrandForm textarea[name="description"]').val(brand.description);
                $('#editBrandForm input[name="website"]').val(brand.website);
                $('#editBrandForm input[name="sort_order"]').val(brand.sort_order);
                $('#editBrandForm select[name="status"]').val(brand.status);

                // Show current logo if exists
                if (brand.logo_url) {
                    $('#editBrandLogoPreview')
                        .removeClass('d-none')
                        .attr('src', brand.logo_url);
                } else {
                    $('#editBrandLogoPreview').addClass('d-none');
                }

                // Set form action URL
                $('#editBrandForm').attr('action', '/admin/brands/' + brand.id);
                $('#editBrandForm input[name="id"]').val(brand.id);

                // Open the modal
                $('#editBrandModal').modal('show');
            },
            error: function (err) {
                alert('Error loading brand data.');
                console.error(err);
            }
        });
    });
});
</script>
<script> // Auto-generate slug when name changes (create & edit)
    $(document).on('input', '#editBrandForm input[name="name"], #nameInput', function () {
        let slug = $(this).val()
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
        $('#editBrandForm input[name="slug"], #slugInput').val(slug);
    });

    // Preview logo image (edit form)
    $(document).on('change', '#editBrandForm input[name="logo"]', function () {
        const preview = document.getElementById('editBrandLogoPreview');
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                preview.style.display = 'block';
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
</script>
<script>
$(document).ready(function () {
    $('.toggle-status').on('change', function () {
        const checkbox = $(this);
        const isChecked = checkbox.is(':checked');
        const status = isChecked ? 1 : 0;
        const brandId = checkbox.data('id');
        const $badge = checkbox.closest('td').find('.status-badge');

        checkbox.prop('disabled', true);

        $.ajax({
            url: "{{ route('brands.toggleStatus') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: brandId,
                status: status
            },
            success: function (response) {
                if (response.success) {
                    $badge
                        .removeClass('bg-success bg-danger')
                        .addClass(status ? 'bg-success' : 'bg-danger')
                        .text(status ? 'Active' : 'Inactive');
                } else {
                    checkbox.prop('checked', !isChecked);
                    alert("Failed to update status.");
                }
            },
            error: function () {
                checkbox.prop('checked', !isChecked);
                alert("Error updating status.");
            },
            complete: function () {
                checkbox.prop('disabled', false);
            }
        });
    });
});
</script>



@endpush