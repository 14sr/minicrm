@extends('layouts.master')

@section('title', 'Companies')

@section('content')
<div class="container mt-4">
    <h2>Companies</h2>

    <!-- Button to Open the Add Company Modal -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addCompanyModal">
        Add Company
    </button>

    <!-- Success/Error Messages (Optional, but good practice) -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Companies Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Logo</th>
                    <th>Website</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                {{-- Assuming $companies is passed from your controller --}}
                @forelse ($companies as $company)
                    <tr>
                        <td>{{ $company->id }}</td>
                        <td>{{ $company->name }}</td>
                        <td>{{ $company->email }}</td>
                        <td>
                            @if ($company->logo)
                                <img src="{{ asset('storage/' . $company->logo) }}" alt="{{ $company->name }} Logo" style="max-width: 50px; max-height: 50px;">
                            @else
                                No Logo
                            @endif
                        </td>
                        <td><a href="{{ $company->website }}" target="_blank">{{ $company->website }}</a></td>
                        <td>
                            <!-- Edit Button -->
                            <button type="button" class="btn btn-warning btn-sm edit-company-btn"
                                data-bs-toggle="modal"
                                data-bs-target="#editCompanyModal"
                                data-id="{{ $company->id }}"
                                data-name="{{ $company->name }}"
                                data-email="{{ $company->email }}"
                                data-website="{{ $company->website }}"
                                data-logo-url="{{ $company->logo ? asset('storage/' . $company->logo) : '' }}"
                            >
                                Edit
                            </button>

                            <!-- Delete Button (Optional) -->
                            <form action="{{ route('companies.destroy', $company->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this company?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No companies found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Add Company Modal (Your existing modal) -->
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
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Company Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="logo" class="form-label">Company Logo (.jpg/.png only)</label>
                        <input type="file" name="logo" class="form-control">
                        @error('logo')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="website" class="form-label">Website</label>
                        <input type="text" name="website" class="form-control" value="{{ old('website') }}">
                        @error('website')
                            <div class="text-danger">{{ $message }}</div>
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

<!-- Edit Company Modal (NEW MODAL) -->
<div class="modal fade" id="editCompanyModal" tabindex="-1" aria-labelledby="editCompanyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCompanyModalLabel">Edit Company</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{-- The form action will be set by JavaScript --}}
            <form id="editCompanyForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') {{-- Use PUT method for updates --}}
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Company Name</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                         @error('name') {{-- This error might not show up directly on modal re-open without JS handling --}}
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="edit_email" class="form-label">Company Email</label>
                        <input type="email" name="email" id="edit_email" class="form-control">
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="edit_logo" class="form-label">Company Logo (.jpg/.png only)</label>
                        <input type="file" name="logo" id="edit_logo" class="form-control">
                        <small class="form-text text-muted mt-2">Leave blank to keep current logo.</small>
                        <div id="current_logo_preview" class="mt-2">
                            <img src="" alt="Current Logo" style="max-width: 100px; max-height: 100px; display: none;">
                            <span class="ms-2 text-muted" style="display: none;">No current logo</span>
                        </div>
                        @error('logo')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="edit_website" class="form-label">Website</label>
                        <input type="text" name="website" id="edit_website" class="form-control">
                        @error('website')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
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

@endsection

@push('scripts') {{-- Assuming you have a stack for scripts in master.blade.php --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var editCompanyModal = document.getElementById('editCompanyModal');
        editCompanyModal.addEventListener('show.bs.modal', function (event) {
            // Button that triggered the modal
            var button = event.relatedTarget;

            // Extract info from data-* attributes
            var id = button.getAttribute('data-id');
            var name = button.getAttribute('data-name');
            var email = button.getAttribute('data-email');
            var website = button.getAttribute('data-website');
            var logoUrl = button.getAttribute('data-logo-url');

            // Update the modal's content.
            var modalTitle = editCompanyModal.querySelector('.modal-title');
            var modalForm = editCompanyModal.querySelector('#editCompanyForm');
            var modalInputName = editCompanyModal.querySelector('#edit_name');
            var modalInputEmail = editCompanyModal.querySelector('#edit_email');
            var modalInputWebsite = editCompanyModal.querySelector('#edit_website');
            var currentLogoPreviewImg = editCompanyModal.querySelector('#current_logo_preview img');
            var currentLogoPreviewText = editCompanyModal.querySelector('#current_logo_preview span');


            modalTitle.textContent = 'Edit Company: ' + name;
            modalForm.action = '/companies/' + id; // Dynamically set the form action

            modalInputName.value = name;
            modalInputEmail.value = email;
            modalInputWebsite.value = website;

            // Handle logo preview
            if (logoUrl) {
                currentLogoPreviewImg.src = logoUrl;
                currentLogoPreviewImg.style.display = 'block';
                currentLogoPreviewText.style.display = 'none';
            } else {
                currentLogoPreviewImg.src = '';
                currentLogoPreviewImg.style.display = 'none';
                currentLogoPreviewText.style.display = 'inline';
            }
        });
    });
</script>
@endpush