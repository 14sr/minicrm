@extends('layouts.master')

@section('title', 'Employees')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Employees</h2>
        <!-- Button to trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
            Add Employee
        </button>
    </div>

    {{-- Flash Message --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Employees Table --}}
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Company</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="employee-table">
            @foreach ($employees as $employee)
                <tr id="employee-{{ $employee->id }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $employee->first_name & $employee->last_name  }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->phone }}</td>
                    <td>{{ $employee->company->name ?? '-' }}</td>

                    <td>
                        <button type="button" class="btn btn-sm btn-warning editEmployeeBtn" data-bs-toggle="modal" data-bs-target="#editEmployeeModal" data-id="{{ $employee->id }}">
                            Edit
                        </button>

                        <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure to delete this employee?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center">
        {{ $employees->links() }}
    </div>
</div>

{{-- Add Employee Modal --}}
<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('employees.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" required>
                        @error('first_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" required>
                        @error('last_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                        @error('phone')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="company_id" class="form-label">Company</label>
                        <select name="company_id" class="form-control" required>
                            <option value="">Select Company</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                    {{ $company->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('company_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- Edit Employee Modal --}}
<div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-labelledby="editEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editEmployeeForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="editEmployeeId" name="employee_id">
                <div class="modal-body">
                    <input type="text" id="edit_first_name" name="first_name" class="form-control mb-3" placeholder="First Name">
                    <input type="text" id="edit_last_name" name="last_name" class="form-control mb-3" placeholder="Last Name">
                    <input type="email" id="edit_email" name="email" class="form-control mb-3" placeholder="Email">
                    <input type="text" id="edit_phone" name="phone" class="form-control mb-3" placeholder="Phone">
                    <input type="text" id="edit_company" name="company_id" class="form-control mb-3" placeholder="Company">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.editEmployeeBtn');

    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const employeeId = this.dataset.id;

            fetch(`/employees/${employeeId}/edit`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('editEmployeeId').value = data.id;
                    document.getElementById('edit_first_name').value = data.first_name;
                    document.getElementById('edit_last_name').value = data.last_name;
                    document.getElementById('edit_email').value = data.email ?? '';
                    document.getElementById('edit_phone').value = data.phone ?? '';
                    document.getElementById('edit_company').value = data.company ?? '';



                    const form = document.getElementById('editEmployeeForm');
                    form.action = `/employees/${employeeId}`;

                    const modalEl = document.getElementById('editEmployeeModal');
                    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                    modal.show();
                })
                .catch(err => console.error(err));
        });
    });
});
</script>
@endpush

@endsection
