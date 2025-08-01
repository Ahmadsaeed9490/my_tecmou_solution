@extends('layout.master')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>All Users</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">Add User</button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive bg-white p-3 rounded shadow-sm">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Username</th>
                    <th>Status</th>
                    <th>Last Login</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>
                        @if($user->profile_photo)
                            <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Photo" width="40" height="40">
                        @else
                            <span class="text-muted">No Photo</span>
                        @endif
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->username }}</td>
                    <td>
                        <span class="badge bg-{{ $user->status ? 'success' : 'secondary' }}">
                            {{ $user->status ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>{{ $user->last_login_at ?? 'N/A' }}</td>
                    <td>
                        <button class="btn btn-sm btn-info editUserBtn" data-id="{{ $user->id }}" data-bs-toggle="modal" data-bs-target="#editUserModal">Edit</button>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Add User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body row g-3">
        @include('admin.users.partials.add-user-modal')
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Create User</button>
      </div>
    </form>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form id="editUserForm" method="POST" enctype="multipart/form-data" class="modal-content">
      @csrf
      @method('PUT')
      <div class="modal-header">
        <h5 class="modal-title">Edit User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body row g-3">
        @include('admin.users.partials.edit-user-modal')
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update User</button>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
$('.editUserBtn').on('click', function () {
    const id = $(this).data('id');
    $.ajax({
        url: '/admin/users/' + id + '/edit',
        type: 'GET',
        success: function (user) {
            $('#editUserForm').attr('action', '/admin/users/' + user.id);
            $('#editUserForm input[name="name"]').val(user.name);
            $('#editUserForm input[name="email"]').val(user.email);
            $('#editUserForm input[name="phone"]').val(user.phone);
            $('#editUserForm input[name="username"]').val(user.username);
            $('#editUserForm.select[name="role_id"]').val(user.role_id);
            $('#editUserForm.select[name="status"]').val(user.status);
            $('#editUserForm input[name="last_login_at"]').val(user.last_login_at);
            $('#editUserForm input[name="last_login_ip"]').val(user.last_login_ip);
            if (user.profile_photo) {
                $('#editUserPhotoPreview').attr('src', '/storage/' + user.profile_photo).removeClass('d-none');
            }
        }
    });
});
</script>
