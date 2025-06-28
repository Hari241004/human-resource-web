<!-- resources/views/superadmin/partials/sidebar.blade.php -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('superadmin.dashboard') }}">
    <div class="sidebar-brand-icon">
      <i class="fas fa-crown"></i>
    </div>
    <div class="sidebar-brand-text mx-3">SuperAdmin</div>
  </a>

  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item {{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('superadmin.dashboard') }}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span>
    </a>
  </li>

  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">
    Management
  </div>

  <!-- Nav Item - Users -->
  <li class="nav-item {{ request()->routeIs('superadmin.users.*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('superadmin.users.index') }}">
      <i class="fas fa-fw fa-users"></i>
      <span>User Management</span>
    </a>
  </li>

  <!-- Nav Item - Reports -->
  <li class="nav-item">
    <a class="nav-link" href="#">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>Reports</span>
    </a>
  </li>

  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
  