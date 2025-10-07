@extends('layouts.master')

@section('title', 'Companies')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Companies</h2>
        <!-- Button to trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCompanyModal">
            Add Company
        </button>
    </div>

    {{-- Flash Message --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Companies Table --}}
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Logo</th>
                <th>Name</th>
                <th>Email</th>
                <th>Website</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="company-table">
            @foreach ($companies as $company)
                <tr id="company-{{ $company->id }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if($company->logo)
                            <img src="{{ asset($company->logo) }}" width="60" height="60" alt="Logo">
                        @else
                            <span class="text-muted">No Logo</span>
                        @endif
                    </td>
                    <td>{{ $company->name }}</td>
                    <td>{{ $company->email }}</td>
                    <td>{{ $company->website }}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-warning editCompanyBtn" data-bs-toggle="modal" data-bs-target="#editCompanyModal" data-id="{{ $company->id }}">
                        Edit
                    </button>

                        <form action="{{ route('companies.destroy', $company->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure to delete this company?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center">
        {{ $companies->links() }}
    </div>
</div>

{{-- Add Company Modal --}}
<div class="modal fade" id="addCompanyModal" tabindex="-1" aria-labelledby="addCompanyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCompanyModalLabel">Add New Company</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('companies.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                   <div class="mb-3">
                    <label for="name" class="form-label">Company Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Company Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="logo" class="form-label">Company Logo (.jpg/.png only)</label>
                    <input type="file" name="logo" class="form-control">
                    @error('logo')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="website" class="form-label">Website</label>
                    <input type="text" name="website" class="form-control" value="{{ old('website') }}">
                    @error('website')
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


<!-- Edit Company Modal -->

<!-- <div class="modal fade" id="editCompanyModal" tabindex="-1" aria-labelledby="editCompanyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Company</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editCompanyForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="editCompanyId" name="company_id">
                <div class="modal-body">
                    <input type="text" id="edit_name" name="name" class="form-control mb-4" placeholder="Company Name">
                    <input type="email" id="edit_email" name="email" class="form-control mb-4" placeholder="Email">
                    <input type="text" id="edit_website" name="website" class="form-control mb-4" placeholder="Website">
                    <input type="file" id="edit_logo" name="logo" class="form-control mt-4">
                    <img id="current_logo" src="" width="60" height="60" class="mt-2">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div> -->

{{-- Edit Company Modal --}}
<div class="modal fade" id="editCompanyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editCompanyForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="editCompanyId" name="company_id">

                <div class="modal-header">
                    <h5 class="modal-title">Edit Company</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Name</label>
                        <input type="text" id="edit_name" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_email" class="form-label">Email</label>
                        <input type="email" id="edit_email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_website" class="form-label">Website</label>
                        <input type="text" id="edit_website" name="website" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="edit_logo" class="form-label">Logo</label>
                        <input type="file" id="edit_logo" name="logo" class="form-control">
                        <img id="current_logo" src="" alt="Current Logo" class="img-fluid mt-2" style="max-height: 100px;">
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




@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.editCompanyBtn');

    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const companyId = this.dataset.id;

            fetch(`/companies/${companyId}/edit`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('editCompanyId').value = data.id;
                    document.getElementById('edit_name').value = data.name;
                    document.getElementById('edit_email').value = data.email ?? '';
                    document.getElementById('edit_website').value = data.website ?? '';
                    document.getElementById('current_logo').src = data.logo ? '/' + data.logo : '';

                    const form = document.getElementById('editCompanyForm');
                    form.action = `/companies/${companyId}`;

                    const modalEl = document.getElementById('editCompanyModal');
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
