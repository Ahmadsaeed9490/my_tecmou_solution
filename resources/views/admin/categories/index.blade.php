@extends('layout.master')
@section('content')

<div class="container-fluid pt-4 px-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>All Categories</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_category_Modal">Add Category</button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive bg-white p-3 rounded shadow-sm">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Slug</th>
                      <th>Description</th>
                      <th>Image</th>
                      <th>Status</th>
                      <th>Sort Order</th>
                      <th>Actions</th>
                </tr>
            </thead>
           <tbody>
            @foreach ($categories as $category)
              <tr class="category-row">
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->slug }}</td>
                <td>{{ \Illuminate\Support\Str::limit($category->description, 50) }}</td>
                 <td>
                        <span class="badge bg-{{ $category->status ? 'success' : 'danger' }}">
                            {{ $category->status ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                      <td>
                        @if($category->image)
                          <img src="{{ asset('storage/' . $category->image) }}" alt="Image" width="40">
                        @endif
                      </td>

                <td>{{ $category->status ? 'Active' : 'Inactive' }}</td>
                <td>{{ $category->sort_order }}</td>
                <td>
                  <a href="javascript:void(0)" onclick="editCategory({{ $category->id }})" class="btn btn-sm btn-warning">Edit</a>
                  <button onclick="setDeleteId({{ $category->id }})" class="btn btn-sm btn-danger">Delete</button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="add_category_Modal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Category</h5>
        </div>
        <div class="modal-body">
          @include('admin.categories.partials.add-category-modal', ['category' => null])
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
    <form method="POST" id="edit-category-form" enctype="multipart/form-data" action="{{ url('admin/categories/0') }}">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Category</h5>
        </div>
        <div class="modal-body">
          @include('admin.categories.partials.edit-category-modal', ['category' => null])
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
    <form method="POST" id="deleteForm" action="{{ url('admin/categories/0') }}">
      @csrf
      @method('DELETE')
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
      url: "{{ url('admin/categories') }}/" + id + "/edit",
      type: 'GET',
      success: function(data) {
        $('#edit-category-form').attr('action', "{{ url('admin/categories') }}/" + id);
        $('#edit-category-form input[name="name"]').val(data.name);
        $('#edit-category-form input[name="slug"]').val(data.slug);
        $('#edit-category-form textarea[name="description"]').val(data.description);
        $('#edit-category-form input[name="sort_order"]').val(data.sort_order);
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
    $('#deleteForm').attr('action', "{{ url('admin/categories') }}/" + id);
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
@endsection
