@extends('layout.master')
@section('content')

    <div class="container mt-4">
        <h3 class="text-center">User Management</h3>

        @if(session('success'))
            <div class="alert alert-success" id="success-alert">{{ session('success') }}</div>
        @endif

        

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        

        <div class="text-end my-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Add New User</button>
        </div>


        <!-- User Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <input type="checkbox"
                                class="form-check-input toggle-status"
                                data-id="{{ $user->id }}"
                                {{ $user->status ? 'checked' : '' }}>

                            <span class="ms-1 badge bg-{{ $user->status ? 'success' : 'danger' }}">
                                {{ $user->status ? 'Active' : 'Inactive' }}
                        </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">Edit</button>
                         <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" class="d-inline">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                        </td>
                    </tr>


                    
                  
                    <!-- Edit User Modal -->
<div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="{{ route('admin.users.update', $user->id) }}" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User - {{ $user->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body row g-3">
                    @include('admin.users.partials.edit_user_modal')
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update User</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog">
   <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">
    @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New User</h5>
                    </div>
                    <div class="modal-body">
                  @include('admin.users.partials.add_user_modal')

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary">Create</button>
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<script>
$(document).ready(function () {
    $('.toggle-status').on('change', function () {
        let isChecked = $(this).is(':checked');
        let status = isChecked ? 1 : 0;
        let userid = $(this).data('id');
        let $badge = $(this).next('span');

        $.ajax({
            url: "{{ route('users.toggleStatus') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: userid,
                status: status
            },
            success: function (response) {
                if (response.success) {
                    $badge
                        .removeClass('bg-success bg-danger')
                        .addClass(status ? 'bg-success' : 'bg-danger')
                        .text(status ? 'Active' : 'Inactive');
                } else {
                    alert("Failed to update status.");
                }
            },
            error: function () {
                alert("Error updating status.");
            }
        });
    });

    // Success alert ko 3 seconds baad hide karne ka code
    setTimeout(function() {
        $('#success-alert').fadeOut('slow');
    }, 3000);
});
</script>
@endsection