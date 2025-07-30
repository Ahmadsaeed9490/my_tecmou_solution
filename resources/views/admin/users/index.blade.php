@extends('layout.master')
@section('content')

<div class="container mt-4">
    <h3 class="text-center">User Management</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <button class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#addUserModal">Add New User</button>

    <!-- User Table -->
    <table class="table table-bordered">
        <thead>
            <tr><th>#</th>
                <th>Name</th>
                <th>Email</th>
               <th> status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->status }}</td>
                <td>
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">Edit</button>
                    <form method="POST" action="{{ route('admin.users.delete', $user->id) }}" class="d-inline">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>

            <!-- Edit Modal -->
            <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header"><h5 class="modal-title">Edit User</h5></div>
                            <div class="modal-body">
                                <input type="text" name="name" value="{{ $user->name }}" class="form-control mb-2" required>
                                <input type="email" name="email" value="{{ $user->email }}" class="form-control mb-2" required>
                                <input type="password" name="password" placeholder="New Password (Optional)" class="form-control mb-2">
                                <input type="password" name="password_confirmation" placeholder="Confirm Password" class="form-control mb-2">
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success">Update</button>
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
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
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Add New User</h5></div>
                <div class="modal-body">
                    <input type="text" name="name" placeholder="Name" class="form-control mb-2" required>
                    <input type="email" name="email" placeholder="Email" class="form-control mb-2" required>
                    <input type="password" name="password" placeholder="Password" class="form-control mb-2" required>
                    <input type="password" name="password_confirmation" placeholder="Confirm Password" class="form-control mb-2" required>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Create</button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
