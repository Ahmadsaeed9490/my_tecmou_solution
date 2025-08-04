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
                            <td>
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input toggle-product-status"
                                        data-id="{{ $product->id }}" {{ $product->status ? 'checked' : '' }} />
                                    <span
                                        class="badge product-status-badge {{ $product->status ? 'bg-success' : 'bg-danger' }}">
                                        {{ $product->status ? 'Active' : 'Inactive' }}
                                    </span>
                                    </label>
                                </div>
                            </td>
                            <td>
                                <button onclick="editProduct({{ $product->id }})" class="btn btn-sm btn-info">Edit</button>
                                <button onclick="deleteProduct({{ $product->id }})"
                                    class="btn btn-sm btn-danger">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Create Modal -->
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
                    $('#edit-sku').val(data.sku);
                    $('#edit-model').val(data.model);
                    $('#edit-category').val(data.category_id);
                    $('#edit-brand').val(data.brand_id);
                    $('#edit-price').val(data.price);
                    $('#edit-discount').val(data.discount);
                    $('#edit-stock').val(data.stock_quantity);
                    $('#edit-status').val(data.status);
                    $('#edit-featured').val(data.is_featured);
                    $('#edit-description').val(data.description);
                    $('#edit-specifications').val(data.specifications);
                    $('#edit-warranty').val(data.warranty);

                    // Reset slug manual edit flag when modal opens
                    window.isSlugManuallyEdited = false;

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

<script>
    $(document).on('change', '.toggle-product-status', function (e) {
        e.preventDefault();

        const checkbox = $(this);
        const isChecked = checkbox.is(':checked');
        const status = isChecked ? 1 : 0;
        const productId = checkbox.data('id');
        const $badge = checkbox.closest('td').find('.product-status-badge');

        // Show confirmation before updating
        const confirmMsg = status ? "Are you sure you want to active this product?" 
                                  : "Are you sure you want to inactive this product?";

        if (!confirm(confirmMsg)) {
            checkbox.prop('checked', !isChecked); // Revert back
            return; // Do not proceed
        }

        checkbox.prop('disabled', true);

        $.ajax({
            url: "{{ route('products.toggleStatus') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: productId,
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
                alert("Error occurred while updating status.");
            },
            complete: function () {
                checkbox.prop('disabled', false);
            }
        });
    });
</script>

@endsection