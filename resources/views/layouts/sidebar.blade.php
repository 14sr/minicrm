<!-- Include Bootstrap Icons in your layout head if not already -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<!-- <div class="list-group list-group-flush">
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
</div> -->



  <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="{{ url('/dashboard') }}" class="text-nowrap logo-img">
            <img src="assets/images/logos/logo.svg" alt="" />
          </a>
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-6"></i>
          </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
          <ul id="sidebarnav">
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ url('/dashboard') }}" aria-expanded="false">
                <i class="ti ti-atom"></i>
                <span class="hide-menu">Dashboard</span>
              </a>
            </li>
             <li class="sidebar-item">
              <a class="sidebar-link justify-content-between"  
               href="{{ route('users.index') }}"
                aria-expanded="false">
                <div class="d-flex align-items-center gap-3">
                  <span class="d-flex">
                    <i class="ti ti-user-circle"></i>
                  </span>
                  <span class="hide-menu">User</span>
                </div>
                
              </a>
            </li>
        
            <li class="sidebar-item">
              <a class="sidebar-link justify-content-between"  
                href="{{ route('companies.index') }}" aria-expanded="false">
                <div class="d-flex align-items-center gap-3">
                  <span class="d-flex">
                    <i class="ti ti-layout-kanban"></i>
                  </span>
                  <span class="hide-menu">Company</span>
                </div>
                
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link justify-content-between"  
                href="{{ route('employees.index') }}" aria-expanded="false">
                <div class="d-flex align-items-center gap-3">
                  <span class="d-flex">
                    <i class="ti ti-accessible"></i>
                  </span>
                  <span class="hide-menu">Employee</span>
                </div>
                
              </a>
            </li>
             <li class="sidebar-item">
              <a class="sidebar-link justify-content-between"  
               href="{{ route('profile.edit') }}"
                aria-expanded="false">
                <div class="d-flex align-items-center gap-3">
                  <span class="d-flex">
                    <i class="ti ti-user-circle"></i>
                  </span>
                  <span class="hide-menu">Profile</span>
                </div>
                
              </a>
            </li>
           
          </ul>
        </nav>
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>
    <!--  Sidebar End -->
