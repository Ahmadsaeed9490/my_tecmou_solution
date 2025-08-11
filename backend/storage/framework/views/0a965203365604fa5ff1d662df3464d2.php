<?php $__env->startSection('content'); ?>
<style>
.category-name {
    cursor: pointer;
    text-decoration: none;
    transition: all 0.3s ease;
}

.category-name:hover {
    text-decoration: underline;
    transform: translateX(2px);
}

.category-name.text-success {
    font-weight: bold;
}

.subcategory-row {
    background-color: #f8f9fa;
}

.subcategory-row td {
    border-top: none;
    padding: 0;
}

.subcategory-row .table {
    margin-bottom: 0;
    background-color: white;
    border-radius: 0.375rem;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.subcategory-row .table td {
    padding: 0.5rem;
    vertical-align: middle;
}

.subcategory-row .table thead th {
    background-color: #e9ecef;
    border-color: #dee2e6;
    font-weight: 600;
    font-size: 0.875rem;
}

.subcategory-row .btn-sm {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
}

/* Form validation styles */
.form-control.is-invalid {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

.form-control.is-valid {
    border-color: #198754;
    box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
}

.invalid-feedback {
    display: block;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.875em;
    color: #dc3545;
}

/* Modal styling */
#addSubcategoryModal .modal-dialog {
    max-width: 600px;
}

#addSubcategoryModal .form-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.5rem;
}

#addSubcategoryModal .form-control {
    border-radius: 0.375rem;
    border: 1px solid #ced4da;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

#addSubcategoryModal .form-control:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

#addSubcategoryModal .form-check-input:checked {
    background-color: #198754;
    border-color: #198754;
}

#addSubcategoryModal .form-control[readonly] {
    background-color: #f8f9fa;
    cursor: not-allowed;
}

#addSubcategoryModal .form-text {
    font-size: 0.875em;
    color: #6c757d;
}
</style>

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
            <tr class="category-row" data-id="<?php echo e($category->id); ?>">
                <td><?php echo e($category->id); ?></td>
                <td>
                    <a href="javascript:void(0)" class="text-primary category-name fw-bold">
                        <?php echo e($category->name); ?>

                        <small class="text-muted ms-2">(<?php echo e($category->subcategories ? $category->subcategories->count() : 0); ?> subcategories)</small>
                    </a>
                </td>
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
            <tr class="subcategory-row d-none" id="subcategories-<?php echo e($category->id); ?>">
                <td colspan="7">
                    <div class="p-2 text-muted">Loading subcategories...</div>
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

<!-- Add Subcategory Modal -->
<div class="modal fade" id="addSubcategoryModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" action="<?php echo e(route('admin.subcategories.store')); ?>" enctype="multipart/form-data">
      <?php echo csrf_field(); ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Subcategory</h5>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" required>
          </div>

          <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <label class="form-label">Slug</label>
              <div class="form-check form-switch">
                
                
                  
                </label>
              </div>
            </div>
            <input type="text" name="slug" class="form-control" placeholder="auto-generated if left empty" readonly>
            
          </div>

          <div class="mb-3">
            <label class="form-label">Main Category <span class="text-danger">*</span></label>
            <select name="category_id" id="subcategory_category_id" class="form-control" required>
              <option value="">Select Main Category</option>
              <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($cat->id); ?>"><?php echo e($cat->name); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>
<div class="col-12">
    <label>Description</label>
    <textarea name="description" id="edit-brand-description" class="form-control">
        <?php echo e($brand->description ?? ''); ?>

    </textarea>
</div>
          <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="file" name="image" class="form-control" accept="image/*">
            <small class="form-text text-muted">Max file size: 2MB. Supported formats: JPG, PNG, GIF</small>
          </div>

          <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-control">
              <option value="1">Active</option>
              <option value="0">Inactive</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" onclick="resetSubcategoryForm()">Reset</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save</button>
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
        // Add a small indicator that the system is ready
        console.log('Categories page loaded successfully. Click on any category name to view subcategories.');
        
        // Handle subcategory form submission
        $('#addSubcategoryModal form').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            var formData = new FormData(form);
            
            $.ajax({
                url: $(form).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Close modal
                    $('#addSubcategoryModal').modal('hide');
                    // Show success message
                    showToast('Subcategory created successfully!', 'success');
                    // Reset form
                    form.reset();
                    // Refresh the page to show new subcategory
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        // Validation errors
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = 'Please fix the following errors:\n';
                        for (var field in errors) {
                            errorMessage += field + ': ' + errors[field][0] + '\n';
                        }
                        showToast(errorMessage, 'error');
                    } else {
                        showToast('Failed to create subcategory. Please try again.', 'error');
                    }
                }
            });
        });
        
        // Handle modal close events
        $('#addSubcategoryModal').on('hidden.bs.modal', function() {
            // Reset form and validation states when modal is closed
            var form = $(this).find('form')[0];
            form.reset();
            $(this).find('.form-control').removeClass('is-invalid is-valid');
            $(this).find('.invalid-feedback').remove();
        });
        
        // Handle slug toggle
        $('#customSlugToggle').on('change', function() {
            var slugField = $('#addSubcategoryModal input[name="slug"]');
            if ($(this).is(':checked')) {
                slugField.prop('readonly', false).focus();
            } else {
                slugField.prop('readonly', true);
                // Re-generate slug from name
                var name = $('#addSubcategoryModal input[name="name"]').val();
                if (name) {
                    var slug = name.toLowerCase()
                        .replace(/[^a-z0-9 -]/g, '')
                        .replace(/\s+/g, '-')
                        .replace(/-+/g, '-')
                        .trim('-');
                    slugField.val(slug);
                }
            }
        });
        
        // Auto-generate slug from name
        $('#addSubcategoryModal input[name="name"]').on('input', function() {
            var name = $(this).val();
            var slugField = $('#addSubcategoryModal input[name="slug"]');
            
            // Only auto-generate if slug field is empty
            if (!slugField.val()) {
                var slug = name.toLowerCase()
                    .replace(/[^a-z0-9 -]/g, '') // Remove special characters
                    .replace(/\s+/g, '-') // Replace spaces with hyphens
                    .replace(/-+/g, '-') // Replace multiple hyphens with single hyphen
                    .trim('-'); // Remove leading/trailing hyphens
                slugField.val(slug);
            }
        });
        
        // Real-time form validation
        $('#addSubcategoryModal input, #addSubcategoryModal select, #addSubcategoryModal textarea').on('blur', function() {
            var field = $(this);
            var value = field.val();
            var isRequired = field.prop('required');
            
            if (isRequired && !value) {
                field.addClass('is-invalid').removeClass('is-valid');
                if (!field.next('.invalid-feedback').length) {
                    field.after('<div class="invalid-feedback">This field is required.</div>');
                }
            } else if (value) {
                field.addClass('is-valid').removeClass('is-invalid');
                field.next('.invalid-feedback').remove();
            }
        });
        
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

                // Show success message
                showToast('Status updated successfully!', 'success');
            } else {
                showToast('Status update failed.', 'error');
                checkbox.prop('checked', !newStatus); // Revert
            }
        },
        error: function () {
            showToast('Something went wrong. Try again.', 'error');
            checkbox.prop('checked', !newStatus); // Revert
        },
            complete: function () {
                checkbox.prop('disabled', false);
            }
        });
    });
</script>
<script>
$(document).on('click', '.category-name', function () {
    let categoryId = $(this).closest('tr').data('id');
    let subRow = $('#subcategories-' + categoryId);
    let categoryName = $(this).text();

    if (!subRow.hasClass('d-none')) {
        // Already visible → hide
        subRow.addClass('d-none');
        $(this).removeClass('text-success').addClass('text-primary');
        return;
    }

    // Show loading text with better styling
    subRow.removeClass('d-none').find('td').html(`
        <div class="p-3 text-center">
            <div class="spinner-border spinner-border-sm text-primary me-2" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <span class="text-muted">Loading subcategories for "${categoryName}"...</span>
        </div>
    `);

    // Change category name color to indicate it's active
    $(this).removeClass('text-primary').addClass('text-success');

    // AJAX call
    $.ajax({
        url: "<?php echo e(route('admin.categories.subcategories', ':id')); ?>".replace(':id', categoryId),
        type: 'GET',
        success: function (data) {
            console.log('Subcategories data received:', data);
            if (data.length > 0) {
                let html = '<div class="p-3">';
                html += '<div class="d-flex justify-content-between align-items-center mb-3">';
                html += '<h6 class="mb-0 text-primary">Subcategories for "' + categoryName + '" (' + data.length + ' total):</h6>';
                html += '<button onclick="openAddSubcategoryModal(' + categoryId + ')" class="btn btn-sm btn-success">';
                html += '<i class="fas fa-plus me-1"></i>Add Subcategory</button>';
                html += '</div>';
                html += '<div class="table-responsive">';
                html += '<table class="table table-sm table-bordered">';
                html += '<thead class="table-light">';
                html += '<tr><th>Name</th><th>Slug</th><th>Status</th><th>Created</th><th>Actions</th></tr>';
                html += '</thead><tbody>';
                
                data.forEach(function (sub) {
                    const statusBadge = sub.status ? 
                        '<span class="badge bg-success">Active</span>' : 
                        '<span class="badge bg-danger">Inactive</span>';
                    
                    const createdDate = sub.created_at ? new Date(sub.created_at).toLocaleDateString() : 'N/A';
                    html += `<tr>
                        <td>${sub.name}</td>
                        <td>${sub.slug}</td>
                        <td>${statusBadge}</td>
                        <td>${createdDate}</td>
                        <td>
                            <a href="javascript:void(0)" onclick="editSubcategory(${sub.id})" class="btn btn-sm btn-warning">Edit</a>
                            <button onclick="setDeleteSubcategoryId(${sub.id})" class="btn btn-sm btn-danger">Delete</button>
                        </td>
                    </tr>`;
                });
                
                html += '</tbody></table></div></div>';
                subRow.find('td').html(html);
            } else {
                subRow.find('td').html(`
                    <div class="p-3 text-center">
                        <i class="fas fa-info-circle text-muted me-2"></i>
                        <span class="text-muted">No subcategories found for "${categoryName}".</span>
                        <div class="mt-2">
                            <button onclick="openAddSubcategoryModal(${categoryId})" class="btn btn-sm btn-success">
                                <i class="fas fa-plus me-1"></i>Add First Subcategory
                            </button>
                        </div>
                    </div>
                `);
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error:', xhr.responseText, status, error);
            subRow.find('td').html(`
                <div class="p-3 text-center text-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Error loading subcategories. Please try again.
                </div>
            `);
        }
    });
});
</script>

<script>
// Helper functions for subcategory actions
function editSubcategory(id) {
    // Redirect to subcategory edit page
    window.location.href = "<?php echo e(route('admin.subcategories.edit', ':id')); ?>".replace(':id', id);
}

function setDeleteSubcategoryId(id) {
    // You can implement a delete modal for subcategories here
    if (confirm('Are you sure you want to delete this subcategory?')) {
        // Redirect to delete route or implement AJAX delete
        window.location.href = "<?php echo e(route('admin.subcategories.destroy', ':id')); ?>".replace(':id', id);
    }
}

function openAddSubcategoryModal(categoryId) {
    // Set the category ID in the modal
    $('#subcategory_category_id').val(categoryId);
    // Clear any previous validation states
    $('#addSubcategoryModal .form-control').removeClass('is-invalid is-valid');
    $('#addSubcategoryModal .invalid-feedback').remove();
    // Reset form
    $('#addSubcategoryModal form')[0].reset();
    // Reset slug toggle
    $('#customSlugToggle').prop('checked', false);
    $('#addSubcategoryModal input[name="slug"]').prop('readonly', true);
    // Show the modal
    $('#addSubcategoryModal').modal('show');
}

function resetSubcategoryForm() {
    // Reset form
    $('#addSubcategoryModal form')[0].reset();
    // Clear validation states
    $('#addSubcategoryModal .form-control').removeClass('is-invalid is-valid');
    $('#addSubcategoryModal .invalid-feedback').remove();
    // Reset slug toggle
    $('#customSlugToggle').prop('checked', false);
    $('#addSubcategoryModal input[name="slug"]').prop('readonly', true);
    // Focus on first field
    $('#addSubcategoryModal input[name="name"]').focus();
}

// Toast notification function
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-white bg-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'info'} border-0 position-fixed`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999;';
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    const bsToast = new bootstrap.Toast(toast);
    bsToast.show();
    
    // Remove toast after it's hidden
    toast.addEventListener('hidden.bs.toast', () => {
        document.body.removeChild(toast);
    });
}
</script>

<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('edit-brand-description');
</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\my_tecmou_solution\backend\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>