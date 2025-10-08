@extends('layouts.master')

@section('title', 'Companies')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Companies</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCompanyModal">
            Add Company
        </button>
    </div>

    {{-- Flash Message --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Company Cards --}}
    <div class="row">
        @forelse($companies as $company)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <img src="{{ asset($company->logo ? $company->logo : 'assets/images/noimg.jpg') }}" 
                             class="rounded-circle mb-3" 
                             alt="Logo" width="80" height="80">

                        <h5 class="card-title mb-1">{{ $company->name }}</h5>
                        <p class="text-muted mb-1"><i class="bi bi-envelope"></i> {{ $company->email }}</p>
                        <p class="text-muted small">
                            <i class="bi bi-globe"></i>
                            {{ $company->website ?? '—' }}
                        </p>

                        <div class="d-flex justify-content-center gap-2 mt-3">
                            <button type="button" 
                                    class="btn btn-warning btn-sm editCompanyBtn" 
                                    data-id="{{ $company->id }}">
                                Edit
                            </button>

                            <form action="{{ route('companies.destroy', $company->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this company?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted text-center">No companies found.</p>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-4">
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
                        <label class="form-label">Company Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Company Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Company Logo (.jpg/.png)</label>
                        <input type="file" name="logo" class="form-control">
                        @error('logo')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Website</label>
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
                        <img id="current_logo" src="/assets/images/noimg.jpg" alt="Current Logo" class="img-fluid mt-2" style="max-height: 100px;">
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

            // Use the route helper inside blade to construct correct URL
            fetch(`{{ url('companies') }}/${companyId}/edit`)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    // Fill modal fields
                    document.getElementById('editCompanyId').value = data.id;
                    document.getElementById('edit_name').value = data.name ?? '';
                    document.getElementById('edit_email').value = data.email ?? '';
                    document.getElementById('edit_website').value = data.website ?? '';
                    document.getElementById('current_logo').src = data.logo ? `/${data.logo}` : '/assets/images/noimg.jpg';

                    // Set form action dynamically
                    document.getElementById('editCompanyForm').action = `{{ url('companies') }}/${companyId}`;

                    // Show modal
                    const modalEl = document.getElementById('editCompanyModal');
                    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                    modal.show();
                })
                .catch(error => console.error('Error fetching company:', error));
        });
    });
});



@if ($errors->any())
    document.addEventListener('DOMContentLoaded', function() {
        var addModal = new bootstrap.Modal(document.getElementById('addCompanyModal'));
        addModal.show();
    });


@endif



</script>

@endpush
@endsection
