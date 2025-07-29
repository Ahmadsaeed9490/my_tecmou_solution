@extends('layout.master')

@section('content')
    <div class="content">
        <div class="container-fluid pt-4 px-4 mb-5">
            <div class="border-bottom">
                <h3 class="text-center pb-2 mb-0">All Products</h3>
            </div>

            <div class="card mt-4 rounded-3 border-0 shadow-sm">
                <div class="card-header bg-white border-0 rounded-3">
                    <div class="row my-3 align-items-center">
                        <div class="col-md-4 col-12">
                            <input type="text" id="search-input" class="form-control" placeholder="Search products...">
                        </div>
                        <div class="col-md-6 text-center">
                            @if(session('success'))
                                <div class="alert alert-success" id="success-alert">
                                    {{ session('success') }}
                                </div>
                            @endif
                        </div>
                        <div class="col-md-2 text-end">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createProductModal">
                                Create <i class="bi bi-plus-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive p-2">
                    <table class="table align-middle table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>SKU</th>
                                <th>Model</th>
                                <th>Category</th>
                                <th>Brand</th>
                                <th>Price</th>
                                <th>Discount</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="product-table">
                            @foreach($products as $product)
                                <tr id="product-{{ $product->id }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->slug }}</td>
                                    <td>{{ $product->sku }}</td>
                                    <td>{{ $product->model }}</td>
                                    <td>{{ $product->category->name ?? 'N/A' }}</td>
                                    <td>{{ $product->brand->name ?? 'N/A' }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->discount }}</td>
                                    <td>{{ $product->stock_quantity }}</td>
                                    <td>{{ $product->status == 'active' ? 'Active' : 'Inactive' }}</td>
                                    <td>
                                        <button onclick="editProduct({{ $product->id }})" class="btn btn-sm btn-info">Edit</button>
                                        <button onclick="deleteProduct({{ $product->id }})" class="btn btn-sm btn-danger">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createProductModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form id="createProductForm" method="POST" enctype="multipart/form-data" action="{{ route('admin.products.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @include('admin.products.partials.add-product-modal')
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Product</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="editProductForm" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Product</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body row g-3">
          
            @include('admin.products.partials.edit-product-modal')

          <!-- Add other fields as needed -->
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Update</button>
        </div>
      </div>
    </form>
  </div>
</div>


    <!-- Delete Confirmation -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

      <script>
       function editProduct(id) {
  $.ajax({
    url: `/admin/products/${id}/edit`,
    type: 'GET',
    success: function (data) {
      $('#editProductForm').attr('action', `/admin/products/${id}`);
      $('#edit-id').val(data.id);
      $('#edit-name').val(data.name);
      $('#edit-slug').val(data.slug);
      $('#edit-category').val(data.category_id);
      $('#edit-brand').val(data.brand_id);
    $('#edit-status').val(data.status); // data.status must be 0 or 1

      $('#edit-featured').val(data.is_featured);
      $('#edit-description').val(data.description);

      // Show modal
      $('#editProductModal').modal('show');
    },
    error: function () {
      alert('Failed to load product data.');
    }
  });
}



        function deleteProduct(id) {
            if (confirm('Are you sure to delete this product?')) {
                $('#deleteForm').attr('action', `/admin/products/${id}`).submit();
            }
        }

        // Auto-dismiss alerts
        setTimeout(() => $('#success-alert').fadeOut(), 3000);

        // Add validation error display
        @if ($errors->any())
            let errorMessage = "Please fix the following errors:\n";
            @foreach ($errors->all() as $error)
                errorMessage += "• {{ $error }}\n";
            @endforeach
            alert(errorMessage);
            $('#createProductModal').modal('show');
        @endif
    </script>
@endsection

  
