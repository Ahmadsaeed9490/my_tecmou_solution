<?php $__env->startSection('content'); ?>
<div class="container-fluid pt-4 px-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>All Category</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCategoryModal">Add Category</button>
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
                      <th>Description</th>
                      <th>Status</th>
                      <th>Image</th>
                      <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr class="category-row">
                    <td><?php echo e($category->id); ?></td>
                    <td><?php echo e($category->name); ?></td>
                    <td><?php echo e($category->slug); ?></td>
                    <td><?php echo e(\Illuminate\Support\Str::limit(strip_tags($category->description), 50)); ?></td>
                    <td>
                        <?php if($category->deleted_at): ?>
                            <span class="badge bg-secondary">Deleted</span>
                        <?php else: ?>
                            <div class="form-check form-switch">
                                <input type="checkbox"
                                    class="form-check-input toggle-category-status"
                                    data-id="<?php echo e($category->id); ?>"
                                    <?php echo e($category->status ? 'checked' : ''); ?>>
                                <label class="form-check-label ms-2">
                                    <span class="badge status-badge bg-<?php echo e($category->status ? 'success' : 'danger'); ?>">
                                        <?php echo e($category->status ? 'Active' : 'Inactive'); ?>

                                    </span>
                                </label>
                            </div>
                        <?php endif; ?>
                    </td>
                          <td>
                            <?php if($category->image): ?>
                              <img src="<?php echo e(asset('storage/' . $category->image)); ?>" alt="Image" width="40">
                            <?php endif; ?>
                          </td>
                  <td>
                      <?php if(!$category->deleted_at): ?>
                          <a href="javascript:void(0)" onclick="editCategory(<?php echo e($category->id); ?>)" class="btn btn-sm btn-warning">Edit</a>
                          <button onclick="setDeleteId(<?php echo e($category->id); ?>)" class="btn btn-sm btn-danger">Delete</button>
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
<!-- Add Category Modal -->
<div class="modal fade" id="createCategoryModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" action="<?php echo e(route('admin.categories.store')); ?>" enctype="multipart/form-data">

      <?php echo csrf_field(); ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Category</h5>
        </div>
        <div class="modal-body">
          <?php echo $__env->make('admin.categories.partials.add-category-modal', ['category' => null], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- Edit Category Modal -->
<div class="modal fade" id="edit_category_Modal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" id="edit-category-form" enctype="multipart/form-data" action="<?php echo e(url('admin/categories/0')); ?>">
      <?php echo csrf_field(); ?>
      <?php echo method_field('PUT'); ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Category</h5>
        </div>
        <div class="modal-body">
          <?php echo $__env->make('admin.categories.partials.edit-category-modal', ['category' => null], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- Delete Modal -->
<div class="modal fade" id="delete_category_Modal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" id="deleteForm" action="<?php echo e(url('admin/categories/0')); ?>">
      <?php echo csrf_field(); ?>
      <?php echo method_field('DELETE'); ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Delete Category</h5>
        </div>
        <div class="modal-body">
          Are you sure you want to delete this category?
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
<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  function editCategory(id) {
    $.ajax({
      url: "<?php echo e(url('admin/categories')); ?>/" + id + "/edit",
      type: 'GET',
      success: function(data) {
        $('#edit-category-form').attr('action', "<?php echo e(url('admin/categories')); ?>/" + id);
        $('#edit-category-form input[name="name"]').val(data.name);
        $('#edit-category-form input[name="slug"]').val(data.slug);
        $('#edit-category-form textarea[name="description"]').val(data.description);
        $('#edit-category-form select[name="status"]').val(data.status);
        $('#edit-category-form select[name="parent_id"]').val(data.parent_id);
        $('#edit_category_Modal').modal('show');
      },
      error: function(xhr) {
        alert('Failed to fetch category data.');
        // Optionally show error in modal
      }
    });
  }

  function setDeleteId(id) {
    $('#deleteForm').attr('action', "<?php echo e(url('admin/categories')); ?>/" + id);
    $('#delete-error').addClass('d-none').text('');
    $('#delete_category_Modal').modal('show');
  }

  $(document).ready(function () {
    $('#search-input').on('keyup', function () {
      let value = $(this).val().toLowerCase();
      $('.category-row').filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
      });
    });
    setTimeout(function () {
      $('#success-alert').fadeOut('slow');
    }, 2000);

    $('#deleteForm').on('submit', function(e) {
      var form = this;
      e.preventDefault();
      $.ajax({
        url: $(form).attr('action'),
        type: 'POST',
        data: $(form).serialize(),
        success: function() {
          location.reload();
        },
        error: function(xhr) {
          $('#delete-error').removeClass('d-none').text('Failed to delete category.');
        }
      });
    });
  });
</script>
<script>
    $(document).on('change', '.toggle-category-status', function () {
        const checkbox = $(this);
        const categoryId = checkbox.data('id');
        const newStatus = checkbox.is(':checked') ? 1 : 0;
        const badge = checkbox.closest('div').find('.status-badge');
        // Confirm alert
        const confirmMsg = newStatus
            ? "Are you sure you want to activate this category?"
            : "Are you sure you want to deactivate this category?";

        if (!confirm(confirmMsg)) {
            // User cancelled, revert checkbox
            checkbox.prop('checked', !checkbox.is(':checked'));
            return;
        }

        // Disable switch while processing
        checkbox.prop('disabled', true);

        $.ajax({
            url: "<?php echo e(route('admin.categories.toggleStatus')); ?>", // ✅ Make sure this route exists
            method: 'POST',
            data: {
                _token: "<?php echo e(csrf_token()); ?>",
                id: categoryId,
                status: newStatus
            },
            success: function (response) {
                if (response.success) {
                    // Update badge
                    badge
                        .removeClass('bg-success bg-danger')
                        .addClass(newStatus ? 'bg-success' : 'bg-danger')
                        .text(newStatus ? 'Active' : 'Inactive');

                    alert("Status updated successfully.");
                } else {
                    alert("Status update failed.");
                    checkbox.prop('checked', !newStatus); // Revert
                }
            },
            error: function () {
                alert("Something went wrong. Try again.");
                checkbox.prop('checked', !newStatus); // Revert
            },
            complete: function () {
                checkbox.prop('disabled', false);
            }
        });
    });
</script>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\my_tecmou_solution\backend\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>