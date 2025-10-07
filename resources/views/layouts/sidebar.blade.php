<!-- <div class="bg-light border-end" id="sidebar-wrapper">
    <div class="sidebar-heading">Menu</div>
    <div class="list-group list-group-flush">
        <a href="{{ url('/dashboard') }}" class="list-group-item list-group-item-action">Dashboard</a>
        <a href="{{ url('/profile') }}" class="list-group-item list-group-item-action">Profile</a>
        <a href="{{ url('/settings') }}" class="list-group-item list-group-item-action">Settings</a>
    </div>
</div> -->

<div class="list-group list-group-flush">
    <a href="{{ url('/dashboard') }}" class="list-group-item list-group-item-action">Dashboard</a>
   <a href="{{ route('companies.index') }}" class="list-group-item list-group-item-action">Company</a>
    <a href="{{ route('employees.index') }}" class="list-group-item list-group-item-action">Employee</a>
    <!-- <a href="{{ url('/settings') }}" class="list-group-item list-group-item-action">Settings</a> -->
    <a href="{{ route('users.index') }}" class="list-group-item list-group-item-action">User</a>
</div>
