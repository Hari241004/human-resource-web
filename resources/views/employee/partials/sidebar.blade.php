<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('employee.dashboard') }}">
    <div class="sidebar-brand-icon"><i class="fas fa-user"></i></div>
    <div class="sidebar-brand-text mx-3">Employee</div>
  </a>

  <hr class="sidebar-divider my-0">

  <!-- Dashboard -->
  <li class="nav-item {{ request()->routeIs('employee.dashboard') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('employee.dashboard') }}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span>
    </a>
  </li>

  <hr class="sidebar-divider">
  <div class="sidebar-heading">Transaksi</div>

  <!-- Presensi (collapse: Isi & Pengajuan) -->
  <li class="nav-item {{ request()->routeIs(['employee.presensi.request','employee.presensi.requests.*']) ? 'active' : '' }}">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePresensi"
       aria-expanded="{{ request()->routeIs(['employee.presensi.request','employee.presensi.requests.*']) ? 'true' : 'false' }}"
       aria-controls="collapsePresensi">
      <i class="fas fa-fw fa-calendar-check"></i>
      <span>Presensi</span>
    </a>
    <div id="collapsePresensi"
         class="collapse {{ request()->routeIs(['employee.presensi.request','employee.presensi.requests.*']) ? 'show' : '' }}"
         aria-labelledby="headingPresensi" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <!-- Isi Presensi -->
        <a class="collapse-item {{ request()->routeIs('employee.presensi.request') ? 'active' : '' }}"
           href="{{ route('employee.presensi.request') }}">
          Isi Presensi
        </a>
        <!-- Pengajuan Presensi -->
        <a class="collapse-item {{ request()->routeIs('employee.presensi.requests.*') ? 'active' : '' }}"
           href="{{ route('employee.presensi.requests.index') }}">
          Pengajuan Presensi
        </a>
      </div>
    </div>
  </li>

  <!-- Pengajuan Lembur -->
  <li class="nav-item {{ request()->routeIs('employee.overtime.requests.*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('employee.overtime.requests.create') }}">
      <i class="fas fa-fw fa-clock"></i>
      <span>Pengajuan Lembur</span>
    </a>
  </li>

  <!-- Pengajuan Cuti -->
  <li class="nav-item {{ request()->routeIs('employee.cuti.*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('employee.cuti.request') }}">
      <i class="fas fa-fw fa-umbrella-beach"></i>
      <span>Pengajuan Cuti</span>
    </a>
  </li>

  <!-- Penggajian -->
  <li class="nav-item {{ request()->routeIs('employee.payroll') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('employee.payroll') }}">
      <i class="fas fa-fw fa-money-bill-wave"></i>
      <span>Penggajian</span>
    </a>
  </li>

  <hr class="sidebar-divider d-none d-md-block">

  <!-- Logout -->
  <li class="nav-item">
    <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
      <i class="fas fa-fw fa-sign-out-alt"></i>
      <span>Logout</span>
    </a>
  </li>

  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
