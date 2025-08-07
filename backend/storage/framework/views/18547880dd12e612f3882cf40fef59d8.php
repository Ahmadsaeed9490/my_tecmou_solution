<?php $__env->startSection('content'); ?>
    <div class="container-fluid pt-4 px-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>All Brands</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createBrandModal">Add Brand</button>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <div class="table-responsive bg-white p-3 rounded shadow-sm">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Logo</th>
                        <th>Category_Name</th>
                        <th>Brand_Name</th>
                        <th>Slug</th>
                        <th>Description</th>
                        <th>Website</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($brand->id); ?></td>
                            <td>
                                <?php if($brand->logo): ?>
                                    <img src="<?php echo e(asset('storage/' . $brand->logo)); ?>" alt="Logo" width="40" height="40">
                                <?php else: ?>
                                    <span class="text-muted">No Logo</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($brand->category->name ?? 'N/A'); ?></td>
                            <td><?php echo e($brand->name); ?></td>
                            <td><?php echo e($brand->slug); ?></td>
                            <td><?php echo e(\Illuminate\Support\Str::limit(strip_tags($brand->description), 50)); ?></td>
                            <td><a href="<?php echo e($brand->website); ?>" target="_blank"><?php echo e($brand->website); ?></a></td>
                            <td>
                                <?php if($brand->deleted_at): ?>
                                    <span class="badge bg-secondary">Deleted</span>
                                <?php else: ?>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input toggle-brand-status"
                                            data-id="<?php echo e($brand->id); ?>" <?php echo e($brand->status ? 'checked' : ''); ?>>
                                        <label class="form-check-label ms-2">
                                            <span class="badge status-badge bg-<?php echo e($brand->status ? 'success' : 'danger'); ?>">
                                                <?php echo e($brand->status ? 'Active' : 'Inactive'); ?>

                                            </span>
                                        </label>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if(!$brand->deleted_at): ?>
    <button class="btn btn-sm btn-info editBrandBtn" data-id="<?php echo e($brand->id); ?>" >Edit</button>
    <form action="<?php echo e(route('admin.brands.destroy', $brand->id)); ?>" method="POST" class="d-inline">
        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
        <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
    </form>
<?php else: ?>
    <span class="text-muted">No Actions</span>
<?php endif; ?>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>

     <!-- Edit Modal -->
    <div class="modal fade" id="editBrandModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editBrandModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" id="editBrandForm" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?> <!-- Use PUT method directly -->
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Brand</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body row g-3">
                        <?php echo $__env->make('admin.brands.partials.edit-brand-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update Brand</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createBrandModal" tabindex="-1" aria-labelledby="createBrandModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="<?php echo e(route('admin.brands.store')); ?>" method="POST" enctype="multipart/form-data"
                class="modal-content">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title">Add New Brand</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row g-3">
                    <?php echo $__env->make('admin.brands.partials.add-brand-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Create Brand</button>
                </div>
            </form>
        </div>
    </div>

   

    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
$(document).ready(function () {
    // Prevent modal from closing on outside click
    $('#editBrandModal').modal({
        backdrop: 'static',
        keyboard: false
    });
    
    // Edit button click
    $('.editBrandBtn').on('click', function (e) {
        e.preventDefault();
        const brandId = $(this).data('id');
        
        $.ajax({
            url: '/admin/brands/' + brandId + '/edit',
            type: 'GET',
            success: function (brand) {
                if (!brand.id) {
                    console.error("No ID returned in response.", brand);
                    return;
                }

                // Set form action using Laravel route
                const actionUrl = `/admin/brands/${brand.id}`;
                $('#editBrandForm').attr('action', actionUrl);

                            // Populate form fields
                            $('#editBrandForm input[name="name"]').val(brand.name);
                            $('#editBrandForm input[name="slug"]').val(brand.slug);
                            $('#editBrandForm textarea[name="description"]').val(brand.description);
                            $('#editBrandForm input[name="website"]').val(brand.website);
                            $('#editBrandForm select[name="status"]').val(brand.status);
                            $('#editBrandForm input[name="sort_order"]').val(brand.sort_order);

                // Preview logo
                if (brand.logo) {
                    $('#editBrandLogoPreview')
                        .attr('src', '/storage/' + brand.logo)
                        .removeClass('d-none')
                        .show();
                } else {
                    $('#editBrandLogoPreview').addClass('d-none').hide();
                }

                // Show modal
                $('#editBrandModal').modal('show');
            },
            error: function (xhr) {
                console.error("Error fetching brand:", xhr.responseText);
            }
        });
    });
});
</script>
<script>
$(document).ready(function () {
    $(document).on('change', '.toggle-brand-status', function (e) {
        e.preventDefault();

        const checkbox = $(this);
        const isChecked = checkbox.is(':checked');
        const status = isChecked ? 1 : 0;
        const brandId = checkbox.data('id');
        const $badge = checkbox.closest('td').find('.status-badge');

        // Confirmation Alert
        const confirmChange = confirm("Are you sure you want to change the brand status?");

        if (!confirmChange) {
            checkbox.prop('checked', !isChecked); // revert back
            return;
        }

        // Proceed with AJAX
        checkbox.prop('disabled', true);

        $.ajax({
            url: "<?php echo e(route('admin.brands.toggleStatus')); ?>",
            method: "POST",
            data: {
                _token: "<?php echo e(csrf_token()); ?>",
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
                    checkbox.prop('checked', !isChecked); // revert toggle
                    alert("Failed to update status.");
                }
            },
            error: function () {
                checkbox.prop('checked', !isChecked); // revert toggle
                alert("Error occurred while updating status.");
            },
            complete: function () {
                checkbox.prop('disabled', false);
            }
        });
    });
});
</script>
<script>
    setTimeout(function () {
        var alert = document.getElementById('success-alert');
        if (alert) {
            alert.classList.add('fade-out');
            setTimeout(() => alert.style.display = 'none', 500); // wait for fade out
        }
    }, 2000);
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\my_tecmou_solution\backend\resources\views/admin/brands/index.blade.php ENDPATH**/ ?>