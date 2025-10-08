
<!-- 
<div class="list-group list-group-flush">
    <a href="{{ url('/dashboard') }}" class="list-group-item list-group-item-action">Dashboard</a>
   <a href="{{ route('companies.index') }}" class="list-group-item list-group-item-action">Company</a>
    <a href="{{ route('employees.index') }}" class="list-group-item list-group-item-action">Employee</a>
    <a href="{{ route('users.index') }}" class="list-group-item list-group-item-action">User</a>
</div> -->


<!-- Include Bootstrap Icons in your layout head if not already -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<div class="list-group list-group-flush">
    <a href="{{ url('/dashboard') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="bi bi-speedometer2 me-2"></i> Dashboard
    </a>

    <a href="{{ route('companies.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="bi bi-building me-2"></i> Company
    </a>

    <a href="{{ route('employees.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="bi bi-people-fill me-2"></i> Employee
    </a>

    <a href="{{ route('users.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="bi bi-person-badge me-2"></i> User
    </a>
</div>
