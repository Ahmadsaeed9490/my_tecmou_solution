

<?php $__env->startSection('content'); ?>
<div class="container-fluid pt-4 px-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>All SubCategories</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createSubCategoryModal">
            Add SubCategory
        </button>
    </div>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="table-responsive bg-white p-3 rounded shadow-sm">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Main Category</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="subcategory-row">
                    <td><?php echo e($subcategory->id); ?></td>
                    <td><?php echo e($subcategory->name); ?></td>
                    <td><?php echo e($subcategory->slug); ?></td>
                    <td><?php echo e($subcategory->category->name ?? 'N/A'); ?></td>
                    <td><?php echo e(\Illuminate\Support\Str::limit(strip_tags($subcategory->description), 50)); ?></td>
                    <td>
                        <?php if($subcategory->deleted_at): ?>
                            <span class="badge bg-secondary">Deleted</span>
                        <?php else: ?>
                            <div class="form-check form-switch">
                                <input type="checkbox"
                                    class="form-check-input toggle-subcategory-status"
                                    data-id="<?php echo e($subcategory->id); ?>"
                                    <?php echo e($subcategory->status ? 'checked' : ''); ?>>
                                <label class="form-check-label ms-2">
                                    <span class="badge status-badge bg-<?php echo e($subcategory->status ? 'success' : 'danger'); ?>">
                                        <?php echo e($subcategory->status ? 'Active' : 'Inactive'); ?>

                                    </span>
                                </label>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($subcategory->image): ?>
                            <img src="<?php echo e(asset('storage/' . $subcategory->image)); ?>" alt="Image" width="40">
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if(!$subcategory->deleted_at): ?>
                            <a href="javascript:void(0)" onclick="editSubCategory(<?php echo e($subcategory->id); ?>)" class="btn btn-sm btn-warning">Edit</a>
                            <button onclick="setDeleteId(<?php echo e($subcategory->id); ?>)" class="btn btn-sm btn-danger">Delete</button>
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


<div class="modal fade" id="createSubCategoryModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" action="<?php echo e(route('admin.subcategories.store')); ?>" enctype="multipart/form-data">
      <?php echo csrf_field(); ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add SubCategory</h5>
        </div>
        <div class="modal-body">
            <?php echo $__env->make('admin.subcategories.partials.add-subcategory-modal', ['subcategory' => null], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </div>
    </form>
  </div>
</div>


<div class="modal fade" id="edit_subcategory_Modal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" id="edit-subcategory-form" enctype="multipart/form-data" action="<?php echo e(url('admin/subcategories/0')); ?>">
      <?php echo csrf_field(); ?>
      <?php echo method_field('PUT'); ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit SubCategory</h5>
        </div>
        <div class="modal-body">
            <?php echo $__env->make('admin.subcategories.partials.edit-subcategory-modal', ['subcategory' => null], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </div>
    </form>
  </div>
</div>


<div class="modal fade" id="delete_subcategory_Modal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" id="deleteForm" action="<?php echo e(url('admin/subcategories/0')); ?>">
      <?php echo csrf_field(); ?>
      <?php echo method_field('DELETE'); ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Delete SubCategory</h5>
        </div>
        <div class="modal-body">
          Are you sure you want to delete this subcategory?
          <div id="delete-error" class="alert alert-danger d-none"></div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger">Delete</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  function editSubCategory(id) {
    $.ajax({
      url: "<?php echo e(url('admin/subcategories')); ?>/" + id + "/edit",
      type: 'GET',
      success: function(data) {
        $('#edit-subcategory-form').attr('action', "<?php echo e(url('admin/subcategories')); ?>/" + id);
        $('#edit-subcategory-form input[name="name"]').val(data.name);
        $('#edit-subcategory-form input[name="slug"]').val(data.slug);
        $('#edit-subcategory-form textarea[name="description"]').val(data.description);
        $('#edit-subcategory-form select[name="status"]').val(data.status);
        $('#edit-subcategory-form select[name="category_id"]').val(data.category_id);
        $('#edit_subcategory_Modal').modal('show');
      },
      error: function() {
        alert('Failed to fetch subcategory data.');
      }
    });
  }

  function setDeleteId(id) {
    $('#deleteForm').attr('action', "<?php echo e(url('admin/subcategories')); ?>/" + id);
    $('#delete-error').addClass('d-none').text('');
    $('#delete_subcategory_Modal').modal('show');
  }

  $(document).ready(function () {
    $('#deleteForm').on('submit', function(e) {
      e.preventDefault();
      $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: $(this).serialize(),
        success: function() { location.reload(); },
        error: function() {
          $('#delete-error').removeClass('d-none').text('Failed to delete subcategory.');
        }
      });
    });

    $(document).on('change', '.toggle-subcategory-status', function () {
        const checkbox = $(this);
        const subCategoryId = checkbox.data('id');
        const newStatus = checkbox.is(':checked') ? 1 : 0;
        const badge = checkbox.closest('div').find('.status-badge');

        if (!confirm(newStatus ? "Activate this subcategory?" : "Deactivate this subcategory?")) {
            checkbox.prop('checked', !checkbox.is(':checked'));
            return;
        }

        checkbox.prop('disabled', true);

        $.ajax({
            url: "<?php echo e(route('admin.subcategories.toggleStatus')); ?>",
            method: 'POST',
            data: {
                _token: "<?php echo e(csrf_token()); ?>",
                id: subCategoryId,
                status: newStatus
            },
            success: function (response) {
                if (response.success) {
                    badge.removeClass('bg-success bg-danger')
                         .addClass(newStatus ? 'bg-success' : 'bg-danger')
                         .text(newStatus ? 'Active' : 'Inactive');
                } else {
                    checkbox.prop('checked', !newStatus);
                }
            },
            complete: function () {
                checkbox.prop('disabled', false);
            }
        });
    });
  });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\my_tecmou_solution\backend\resources\views/admin/subcategories/index.blade.php ENDPATH**/ ?>