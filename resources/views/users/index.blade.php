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

    <div class="row">
        @forelse($users as $user)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0 rounded-3 user-card h-100">
                    <div class="card-body text-center">
                        <!-- Optional avatar -->
                        <div class="mb-3">
                            <img src="{{ asset('assets/images/noimg.jpg') }}" 
                                 alt="User Avatar" 
                                 class="rounded-circle border" 
                                 width="60" height="60">
                        </div>
                        <h5 class="card-title mb-1 text-capitalize">{{ $user->name }}</h5>
                        <p class="text-muted mb-2">{{ $user->email }}</p>

                        @if(!empty($user->website))
                            <p class="small text-secondary mb-3">
                                <a href="{{ $user->website }}" target="_blank">{{ $user->website }}</a>
                            </p>
                        @endif

                        <div class="d-flex justify-content-center gap-2">
                            <button class="btn btn-warning btn-sm editUserBtn" data-id="{{ $user->id }}">Edit</button>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure to delete this user?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm px-3">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted text-center">No users found.</p>
        @endforelse
    </div>

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

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="editUserForm">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title">Edit User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" id="editUserId">

          <div class="mb-3">
            <label>Name</label>
            <input type="text" id="edit_name" name="name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Email</label>
            <input type="email" id="edit_email" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Website</label>
            <input type="text" id="edit_website" name="website" class="form-control">
          </div>
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
