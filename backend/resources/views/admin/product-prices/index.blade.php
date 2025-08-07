@extends('layout.master')
@section('content')

  <div class="container-fluid pt-4 px-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
    <h4>All Product Prices</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createProductPriceModal">Add Price</button>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
    </ul>
    </div>
    @endif

    <div class="table-responsive bg-white p-3 rounded shadow-sm">
    <table class="table table-bordered align-middle">
      <thead class="table-light">
      <tr>
        <th>#</th>
        <th>Product_Name</th>
        <th>Min Price</th>
        <th>Max Price</th>
        <th>Discount %</th>
        <th>Final Price</th>
        <th>Currency</th>
        <th>Actions</th>
      </tr>
      </thead>
      <tbody>
      @foreach ($productPrices as $price)
      <tr class="product-row">
        <td>{{ $price->id }}</td>
        <td>{{ $price->product->name ?? 'N/A' }}</td>
        <td>{{ $price->min_price }}</td>
        <td>{{ $price->max_price }}</td>
        <td>{{ $price->discount_percent }}%</td>
        <td>{{ $price->final_price }}</td>
        <td>{{ strtoupper($price->currency) }}</td>
        <td>
        @if ($price->deleted_at)
      <span class="badge bg-secondary">Deleted</span>
      @else
      <a href="javascript:void(0)" onclick="editPrice({{ $price->id }})" class="btn btn-sm btn-info">Edit</a>
      <button onclick="setDeleteId({{ $price->id }})" class="btn btn-sm btn-danger">Delete</button>
      @endif
        </td>
      </tr>
    @endforeach
      </tbody>
    </table>
    </div>
  </div>

  <!-- Create Modal -->
  <div class="modal fade" id="createProductPriceModal" tabindex="-1">
    <div class="modal-dialog">
    <form method="POST" action="{{ route('admin.product-prices.store') }}">
      @csrf
      <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Product Price</h5>
      </div>
      <div class="modal-body">
        @include('admin.product-prices.partials.add-price-modal', ['price' => null])
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
      @csrf
      @method('PUT')
      <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Product Price</h5>
      </div>
      <div class="modal-body">
        @include('admin.product-prices.partials.edit-price-modal', ['price' => null])
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
      @csrf
      @method('DELETE')
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
      type: 'POST', // POST hi rahega, magar _method bhejna ha
      data: $(form).serialize() + '&_method=DELETE',  // 👈 yeh line important ha
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
</script>

@endsection