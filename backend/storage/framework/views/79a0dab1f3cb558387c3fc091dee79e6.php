<?php $__env->startSection('content'); ?>

<style>
  .status-indicator {
    transition: all 0.3s ease;
  }
  
  .form-check-input:disabled {
    opacity: 0.6;
    cursor: not-allowed;
  }
  
  .sync-button-loading {
    position: relative;
  }
  
  .sync-button-loading:disabled {
    opacity: 0.7;
  }
  
  .notification-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    max-width: 400px;
  }
  
  .table th {
    background-color: #f8f9fa;
    border-color: #dee2e6;
    font-weight: 600;
  }
  
  .badge {
    font-size: 0.75em;
    padding: 0.5em 0.75em;
  }
  
  .btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
  }
</style>

  <div class="container-fluid pt-4 px-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
    <h4>All Product Prices</h4>
    <div class="d-flex gap-2">
      <button class="btn btn-warning" onclick="syncAllPricesStatus()">
        <i class="fas fa-sync-alt me-1"></i>Sync Status
      </button>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createProductPriceModal">Add Price</button>
    </div>
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
          <th>Product Name</th>
          <th>Min Price</th>
          <th>Max Price</th>
          <th>Discount %</th>
          <th>Final Price</th>
          <th>Currency</th>
          
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php $__currentLoopData = $productPrices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $price): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr class="product-row">
          <td><?php echo e($price->id); ?></td>
          <td><?php echo e($price->product->name ?? 'N/A'); ?></td>
          <td><?php echo e($price->min_price); ?></td>
          <td><?php echo e($price->max_price); ?></td>
          <td><?php echo e($price->discount_percent); ?>%</td>
          <td><?php echo e($price->final_price); ?></td>
          <td><?php echo e(strtoupper($price->currency)); ?></td>

          
          

          
          <td>
            <?php if($price->deleted_at || ($price->product && $price->product->deleted_at)): ?>
              <span class="badge bg-secondary">Deleted</span>
            <?php elseif($price->status == 0 || !$price->product || $price->product->status == 0): ?>
              <span class="badge bg-warning text-dark">Inactive</span>
            <?php else: ?>
              <a href="javascript:void(0)" onclick="editPrice(<?php echo e($price->id); ?>)" class="btn btn-sm btn-info">Edit</a>
              <button onclick="setDeleteId(<?php echo e($price->id); ?>)" class="btn btn-sm btn-danger">Delete</button>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </tbody>
    </table>
    </div>
  </div>

  <!-- Notification Container -->
  <div id="notification-container" class="notification-container"></div>

  <!-- Create Modal -->
  <div class="modal fade" id="createProductPriceModal" tabindex="-1">
    <div class="modal-dialog">
    <form method="POST" action="<?php echo e(route('admin.product-prices.store')); ?>">
      <?php echo csrf_field(); ?>
      <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Product Price</h5>
      </div>
      <div class="modal-body">
        <?php echo $__env->make('admin.product-prices.partials.add-price-modal', ['price' => null], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
      </div>
    </form>
    </div>
  </div>

  <!-- Edit Modal -->
  <div class="modal fade" id="edit_price_Modal" tabindex="-1">
    <div class="modal-dialog">
    <form method="POST" id="edit-price-form" action="">
      <?php echo csrf_field(); ?>
      <?php echo method_field('PUT'); ?>
      <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Product Price</h5>
      </div>
      <div class="modal-body">
        <?php echo $__env->make('admin.product-prices.partials.edit-price-modal', ['price' => null], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
      </div>
    </form>
    </div>
  </div>

  <!-- Delete Modal -->
  <div class="modal fade" id="delete_price_Modal" tabindex="-1">
    <div class="modal-dialog">
    <form method="POST" id="deleteForm" action="">
      <?php echo csrf_field(); ?>
      <?php echo method_field('DELETE'); ?>
      <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete Product Price</h5>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this product price?
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

  <!-- JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    function editPrice(id) {
    $.ajax({
      url: `/admin/product-prices/${id}/edit`,
      type: 'GET',
      success: function (data) {
      $('#edit-price-form').attr('action', `/admin/product-prices/${id}`);
      $('#edit_product_id').val(data.product_id);
      $('#edit-price-form input[name="min_price"]').val(data.min_price);
      $('#edit-price-form input[name="max_price"]').val(data.max_price);
      $('#edit-price-form input[name="discount_percent"]').val(data.discount_percent);
      $('#edit-price-form input[name="final_price"]').val(data.final_price);
      $('#edit-price-form input[name="currency"]').val(data.currency);
      $('#edit_price_Modal').modal('show');
      },
      error: function (xhr) {
      alert('Failed to load product price data.');
      console.log(xhr.responseText);
      }
    });
    }

    function setDeleteId(id) {
    $('#deleteForm').attr('action', `/admin/product-prices/${id}`);
    $('#delete-error').addClass('d-none').text('');
    $('#delete_price_Modal').modal('show');
    }

    $(document).ready(function () {
    $('#deleteForm').on('submit', function (e) {
      e.preventDefault();
      var form = this;

      $.ajax({
      url: $(form).attr('action'),
      type: 'POST',
      data: $(form).serialize() + '&_method=DELETE',
      success: function () {
        location.reload();
      },
      error: function () {
        $('#delete-error').removeClass('d-none').text('Failed to delete product price.');
      }
      });
    });
    });
  </script>
  <script>
  function calculateFinalPrice() {
      let min = parseFloat(document.querySelector('input[name="min_price"]').value) || 0;
      let max = parseFloat(document.querySelector('input[name="max_price"]').value) || 0;
      let discount = parseFloat(document.querySelector('input[name="discount_percent"]').value) || 0;

      let avgPrice = (min + max) / 2;
      let finalPrice = avgPrice - (avgPrice * (discount / 100));

      // Set the calculated final price
      document.querySelector('input[name="final_price"]').value = finalPrice.toFixed(2);
  }

  document.addEventListener('DOMContentLoaded', function () {
      // Auto calculate when user types in any of the fields
      document.querySelector('input[name="min_price"]').addEventListener('input', calculateFinalPrice);
      document.querySelector('input[name="max_price"]').addEventListener('input', calculateFinalPrice);
      document.querySelector('input[name="discount_percent"]').addEventListener('input', calculateFinalPrice);
  });

  // Enhanced status toggle with better validation and user feedback
  $(document).on('change', '.toggle-price-status', function () {
    const checkbox = $(this);
    const status = checkbox.is(':checked') ? 1 : 0;
    const priceId = checkbox.data('id');
    const productStatus = parseInt(checkbox.data('product-status'));
    const badge = checkbox.closest('td').find('.price-status-badge');
    const row = checkbox.closest('tr');

    // Prevent activation if product is inactive
    if (status && productStatus === 0) {
      alert('Cannot activate price of inactive product. Please activate the product first.');
      checkbox.prop('checked', false);
      return;
    }

    if (!confirm(status ? 'Activate this price?' : 'Deactivate this price?')) {
      checkbox.prop('checked', !checkbox.is(':checked'));
      return;
    }

    checkbox.prop('disabled', true);

    $.ajax({
      url: "<?php echo e(route('admin.product-prices.toggleStatus')); ?>",
      method: "POST",
      data: {
        _token: "<?php echo e(csrf_token()); ?>",
        id: priceId,
        status: status
      },
      success: function (response) {
        if (response.success) {
          // Update badge
          badge
            .removeClass('bg-success bg-danger')
            .addClass(status ? 'bg-success' : 'bg-danger')
            .text(status ? 'Active' : 'Inactive');
          
          // Update actions column
          const actionsCell = row.find('td:last');
          if (status && productStatus === 1) {
            actionsCell.html(`
              <a href="javascript:void(0)" onclick="editPrice(${priceId})" class="btn btn-sm btn-info">Edit</a>
              <button onclick="setDeleteId(${priceId})" class="btn btn-sm btn-danger">Delete</button>
            `);
          } else {
            actionsCell.html('<span class="badge bg-warning text-dark">Inactive</span>');
          }
          
          // Show success message
          showNotification('Price status updated successfully', 'success');
        } else {
          alert(response.message || "Status update failed.");
          checkbox.prop('checked', !status);
        }
      },
      error: function (xhr) {
        let errorMessage = "Error updating status.";
        if (xhr.responseJSON && xhr.responseJSON.message) {
          errorMessage = xhr.responseJSON.message;
        }
        alert(errorMessage);
        checkbox.prop('checked', !status);
      },
      complete: function () {
        checkbox.prop('disabled', false);
      }
    });
  });

  // Function to show notifications
  function showNotification(message, type = 'info') {
    const notification = $(`
      <div class="alert alert-${type} alert-dismissible fade show mb-2" style="min-width: 300px;">
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    `);
    
    $('#notification-container').append(notification);
    
    // Auto hide after 3 seconds
    setTimeout(() => {
      notification.fadeOut(() => {
        notification.remove();
      });
    }, 3000);
  }

  // Function to sync all product prices status
  function syncAllPricesStatus() {
    if (!confirm('This will synchronize all product prices status with their associated products. Continue?')) {
      return;
    }

    const syncButton = $('button[onclick="syncAllPricesStatus()"]');
    const originalText = syncButton.html();
    
    // Show loading state
    syncButton.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i>Syncing...');

    $.ajax({
      url: "<?php echo e(route('admin.product-prices.syncStatus')); ?>",
      method: "POST",
      data: {
        _token: "<?php echo e(csrf_token()); ?>"
      },
      success: function (response) {
        if (response.success) {
          showNotification(response.message, 'success');
          // Refresh the table data
          refreshTableData();
        } else {
          showNotification(response.message || 'Sync failed', 'danger');
        }
      },
      error: function (xhr) {
        let errorMessage = "Failed to sync product prices status.";
        if (xhr.responseJSON && xhr.responseJSON.message) {
          errorMessage = xhr.responseJSON.message;
        }
        showNotification(errorMessage, 'danger');
      },
      complete: function () {
        // Restore button state
        syncButton.prop('disabled', false).html(originalText);
      }
    });
  }

  // Function to refresh table data without page reload
  function refreshTableData() {
    $.ajax({
      url: window.location.href,
      method: 'GET',
      success: function (data) {
        // Extract the table body content
        const newTableBody = $(data).find('tbody').html();
        $('tbody').html(newTableBody);
        
        // Reinitialize any necessary event handlers
        initializeEventHandlers();
        
        showNotification('Table data refreshed successfully', 'success');
      },
      error: function () {
        showNotification('Failed to refresh table data', 'warning');
        // Fallback to page reload
        setTimeout(() => {
          location.reload();
        }, 2000);
      }
    });
  }

  // Function to initialize event handlers after table refresh
  function initializeEventHandlers() {
    // Re-attach event handlers for new elements
    // This ensures that dynamically loaded content has proper event handling
    $('.toggle-price-status').off('change').on('change', function() {
      // Re-trigger the status toggle logic
      $(this).trigger('change');
    });
  }

  // Listen for product status changes from other pages/tabs
  if (typeof(EventSource) !== "undefined") {
    // You can implement Server-Sent Events here for real-time updates
    // For now, we'll use a simple approach
    window.addEventListener('focus', function() {
      // Refresh data when user returns to the page
      if (document.visibilityState === 'visible') {
        // Optionally refresh the page data
        // location.reload();
      }
    });
  }
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\my_tecmou_solution\backend\resources\views/admin/product-prices/index.blade.php ENDPATH**/ ?>