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
                        <span class="badge bg-{{ $brand->status ? 'success' : 'secondary' }}">
                            {{ $brand->status ? 'Active' : 'Inactive' }}
                        </span>
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
    <form id="editBrandForm" enctype="multipart/form-data" class="modal-content">
      @csrf
      @method('PUT')

      <!-- The form will be populated via AJAX -->
      <div class="modal-header">
        <h5 class="modal-title">Edit Brand</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body row g-3">
        @include('admin.brands.partials.edit-brand-modal')
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update Brand</button>
      </div>
    </form>
{{-- <form method="POST" action="{{ route('admin.brands.update', $brand->id) }}">
    @csrf
    @method('PUT')

      <div class="modal-header">
        <h5 class="modal-title">Edit Brand</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body row g-3">
        @include('admin.brands.partials.edit-brand-modal')
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update Brand</button>
      </div>
    </form>
  </div>
</div> --}}

@endsection

@push('scripts')
<script>
   $('.editBrandBtn').on('click', function () {
    const id = $(this).data('id');
    
    $.ajax({
        url: '/admin/brands/' + id + '/edit',
        type: 'GET',
        success: function (brand) {
          $('#editBrandForm').attr('action', '/admin/brands/' + brand.id);
            $('#editBrandForm input[name="name"]').val(brand.name);
            $('#editBrandForm input[name="slug"]').val(brand.slug);
            $('#editBrandForm textarea[name="description"]').val(brand.description);
            $('#editBrandForm input[name="website"]').val(brand.website);
            $('#editBrandForm select[name="status"]').val(brand.status);
            $('#editBrandForm input[name="sort_order"]').val(brand.sort_order);

            // Optional: show logo preview
            if (brand.logo) {
                $('#editBrandLogoPreview').attr('src', '/storage/' + brand.logo).show();
            }

            $('#editBrandModal').modal('show');
        }
    });
});
  
</script>
@endpush