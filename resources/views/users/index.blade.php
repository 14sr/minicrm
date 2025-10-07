@extends('layouts.master')

@section('title', 'Users')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Users</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
            Add User
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Website</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr id="user-{{ $user->id }}">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->website }}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-warning editUserBtn" data-id="{{ $user->id }}" data-bs-toggle="modal" data-bs-target="#editUserModal">
                        Edit
                    </button>

                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteUserModal" data-id="{{ $user->id }}" data-name="{{ $user->name }}">
                        Delete
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $users->links() }}
    </div>
</div>

{{-- Add User Modal --}}
<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="name" class="form-control mb-2" placeholder="Name" required>
                    <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
                    <input type="text" name="website" class="form-control mb-2" placeholder="Website">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit User Modal --}}
<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editUserForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="editUserId" name="user_id">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="edit_name" name="name" class="form-control mb-2" placeholder="Name">
                    <input type="email" id="edit_email" name="email" class="form-control mb-2" placeholder="Email">
                    <input type="text" id="edit_phone" name="phone" class="form-control mb-2" placeholder="Phone">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Delete User Modal --}}
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="deleteUserForm" method="POST">
        @csrf
        @method('DELETE')
        <div class="modal-header">
          <h5 class="modal-title">Delete User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete <strong id="deleteUserName"></strong>?
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger">Yes, Delete</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    // Edit user
    document.querySelectorAll('.editUserBtn').forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.dataset.id;
            fetch(`/users/${userId}/edit`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('editUserId').value = data.id;
                    document.getElementById('edit_name').value = data.name;
                    document.getElementById('edit_email').value = data.email;
                    document.getElementById('edit_phone').value = data.phone;
                    document.getElementById('editUserForm').action = `/users/${userId}`;
                });
        });
    });

    // Delete user modal
    const deleteModal = document.getElementById('deleteUserModal');
    deleteModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const userId = button.getAttribute('data-id');
        const userName = button.getAttribute('data-name');
        document.getElementById('deleteUserName').textContent = userName;
        document.getElementById('deleteUserForm').action = `/users/${userId}`;
    });

});
</script>
@endpush
@endsection
