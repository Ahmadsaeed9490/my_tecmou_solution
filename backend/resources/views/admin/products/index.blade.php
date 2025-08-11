@extends('layout.master')
@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>All Products</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createProductModal">Add
                Products</button>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive bg-white p-3 rounded shadow-sm">
            <table class="table table-bordered align-middle">
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
                <tbody>
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
                            <td>
                                @if ($product->deleted_at)
                                    <span class="badge bg-secondary">Deleted</span>
                                @else
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input toggle-product-status"
                                            data-id="{{ $product->id }}" {{ $product->status ? 'checked' : '' }}>
                                        <span
                                            class="badge product-status-badge {{ $product->status ? 'bg-success' : 'bg-danger' }}">
                                            {{ $product->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                @endif
                            </td>

                            <td>
                                @if ($product->deleted_at)
                                    <span class="text-muted">No Actions</span>
                                @else
                                    <div class="d-flex gap-2">
                                        <button onclick="editProduct({{ $product->id }})" class="btn btn-sm btn-info">
                                            Edit
                                        </button>
                                        <button onclick="deleteProduct({{ $product->id }})" class="btn btn-sm btn-danger">
                                            Delete
                                        </button>
                                    </div>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="editProductModal" tabindex="-1">
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
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- ✅ Create Modal -->
    <div class="modal fade" id="createProductModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form id="createProductForm" method="POST" enctype="multipart/form-data"
                action="{{ route('admin.products.store') }}">
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
    </div>


    <form id="deleteForm" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>



    <script>
        function editProduct(id) {
            $.ajax({
                url: `/admin/products/${id}/edit`,
                method: 'GET',
                success: function (product) {
                    $('#editProductForm').attr('action', `/admin/products/${id}`);
                    $('#edit-id').val(product.id);
                    $('#edit-name').val(product.name);
                    $('#edit-slug').val(product.slug);
                    $('#edit-sku').val(product.sku);
                    $('#edit-model').val(product.model);
                    $('#edit-category').val(product.category_id);
                    $('#edit-brand').val(product.brand_id);
                    $('#edit-price').val(product.price);
                    $('#edit-discount').val(product.discount);
                    $('#edit-stock').val(product.stock_quantity);
                    $('#edit-status').val(product.status);
                    $('#edit-featured').val(product.is_featured);
                    $('#edit-description').val(product.description);
                    $('#edit-specifications').val(product.specifications);
                    $('#edit-warranty').val(product.warranty);

                    $('#editProductModal').modal('show');
                },
                error: function () {
                    alert('Failed to load product data.');
                }
            });
        }



        $(document).on('change', '.toggle-product-status', function () {
            const checkbox = $(this);
            const status = checkbox.is(':checked') ? 1 : 0;
            const productId = checkbox.data('id');
            const badge = checkbox.closest('td').find('.product-status-badge');

            if (!confirm(status ? 'Activate this product?' : 'Deactivate this product?')) {
                checkbox.prop('checked', !checkbox.is(':checked'));
                return;
            }

            checkbox.prop('disabled', true);

            $.ajax({
                url: "{{ route('admin.products.toggleStatus') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: productId,
                    status: status
                },
                success: function (response) {
                    if (response.success) {
                        badge
                            .removeClass('bg-success bg-danger')
                            .addClass(status ? 'bg-success' : 'bg-danger')
                            .text(status ? 'Active' : 'Inactive');
                    } else {
                        alert("Status update failed.");
                        checkbox.prop('checked', !status);
                    }
                },
                error: function () {
                    alert("Error updating status.");
                    checkbox.prop('checked', !status);
                },
                complete: function () {
                    checkbox.prop('disabled', false);
                }
            });
        });

        $(document).ready(function () {
            // Hide success alert after 2 seconds
            setTimeout(function () {
                $('.alert-success').fadeOut('slow');
            }, 2000);
        });


        function deleteProduct(id) {
            if (confirm("Are you sure you want to delete this product?")) {
                $.ajax({
                    url: `/admin/products/${id}`,
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        _method: "DELETE"
                    },
                    success: function (response) {
                        if (response.success) {
                            const row = $(`#product-${id}`);

                            // ✅ Replace status cell with "Deleted" badge
                            row.find('td:nth-child(11)').html('<span class="badge bg-secondary">Deleted</span>');

                            // ✅ Replace actions cell with "No Actions"
                            row.find('td:nth-child(12)').html('<span class="text-muted">No Actions</span>');

                            // Optional: show a toast or alert
                            alert("Product deleted successfully.");
                        } else {
                            alert("Failed to delete product.");
                        }
                    },
                    error: function () {
                        alert("Error deleting product.");
                    }
                });
            }
        }
    </script>

@endsection