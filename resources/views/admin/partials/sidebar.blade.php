<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
      <div class="sidebar-brand-icon"><i class="fas fa-user-shield"></i></div>
      <div class="sidebar-brand-text mx-3">Admin</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.dashboard') }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span>
      </a>
    </li>

    <hr class="sidebar-divider">
    <div class="sidebar-heading">Management</div>

    <!-- Pegawai -->
    <li class="nav-item {{ request()->routeIs('admin.employees.*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.employees.index') }}">
        <i class="fas fa-fw fa-user-tie"></i>
        <span>Pegawai</span>
      </a>
    </li>    

    <!-- Presensi -->
    <li class="nav-item {{ request()->routeIs('admin.presensi.*') ? 'active' : '' }}">
      <a class="nav-link" href="#">
        <i class="fas fa-fw fa-calendar-check"></i>
        <span>Presensi</span>
      </a>
    </li>

    <!-- Gaji -->
    <li class="nav-item {{ request()->routeIs('admin.gaji.*') ? 'active' : '' }}">
      <a class="nav-link" href="#">
        <i class="fas fa-fw fa-money-bill"></i>
        <span>Gaji</span>
      </a>
    </li>

    <!-- Laporan -->
    <li class="nav-item {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
      <a class="nav-link" href="#">
        <i class="fas fa-fw fa-file-alt"></i>
        <span>Laporan</span>
      </a>
    </li>

    <!-- Logout -->
    <li class="nav-item">
      <a class="nav-link" href="{{ route('logout') }}"
         onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fas fa-fw fa-sign-out-alt"></i>
        <span>Logout</span>
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
      </form>
    </li>

    <hr class="sidebar-divider d-none d-md-block">
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
