{{-- resources/views/layouts/sidebar.blade.php --}}
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
    <div class="sidebar-brand-icon">
      <i class="fas fa-user-shield"></i>
    </div>
    <div class="sidebar-brand-text mx-3">Admin Panel</div>
  </a>

  <hr class="sidebar-divider my-0">

  {{-- Dashboard --}}
  <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.dashboard') }}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span>
    </a>
  </li>

  <hr class="sidebar-divider">

  {{-- Rekrutmen --}}
  <li class="nav-item {{ request()->routeIs('admin.recruitment.*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.recruitment.create') }}">
      <i class="fas fa-fw fa-user-plus"></i>
      <span>Rekrutmen</span>
    </a>
  </li>

  {{-- Pegawai --}}
  <li class="nav-item {{ request()->routeIs('admin.employees.*') || request()->routeIs('admin.departments.*') ? 'active' : '' }}">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePegawai"
       aria-expanded="{{ request()->routeIs('admin.employees.*') || request()->routeIs('admin.departments.*') ? 'true' : 'false' }}"
       aria-controls="collapsePegawai">
      <i class="fas fa-fw fa-users"></i>
      <span>Pegawai</span>
    </a>
    <div id="collapsePegawai"
         class="collapse {{ request()->routeIs('admin.employees.*') || request()->routeIs('admin.departments.*') ? 'show' : '' }}"
         data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item {{ request()->routeIs('admin.employees.*') ? 'active' : '' }}"
           href="{{ route('admin.employees.index') }}">Data Pegawai</a>
        <a class="collapse-item {{ request()->routeIs('admin.departments.*') ? 'active' : '' }}"
           href="{{ route('admin.departments.index') }}">Department</a>
      </div>
    </div>
  </li>

  {{-- Presensi --}}
  <li class="nav-item {{ 
        request()->routeIs('admin.attendance.*') ||
        request()->routeIs('admin.attendance-requests.*') ||
        request()->routeIs('admin.overtime-requests.*') ||
        request()->routeIs('admin.leave-requests.*') ||
        request()->routeIs('admin.attendance-summary.*')
      ? 'active' : '' }}">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePresensi"
       aria-expanded="{{ 
         request()->routeIs('admin.attendance.*') ||
         request()->routeIs('admin.attendance-requests.*') ||
         request()->routeIs('admin.overtime-requests.*') ||
         request()->routeIs('admin.leave-requests.*') ||
         request()->routeIs('admin.attendance-summary.*')
       ? 'true' : 'false' }}"
       aria-controls="collapsePresensi">
      <i class="fas fa-fw fa-calendar-check"></i>
      <span>Presensi</span>
    </a>
    <div id="collapsePresensi"
         class="collapse {{ 
           request()->routeIs('admin.attendance.*') ||
           request()->routeIs('admin.attendance-requests.*') ||
           request()->routeIs('admin.overtime-requests.*') ||
           request()->routeIs('admin.leave-requests.*') ||
           request()->routeIs('admin.attendance-summary.*')
         ? 'show' : '' }}"
         data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item {{ request()->routeIs('admin.attendance.index') ? 'active' : '' }}"
           href="{{ route('admin.attendance.index') }}">Data Presensi</a>
        <a class="collapse-item {{ request()->routeIs('admin.attendance-requests.index') ? 'active' : '' }}"
           href="{{ route('admin.attendance-requests.index') }}">Pengajuan Presensi</a>
        <a class="collapse-item {{ request()->routeIs('admin.overtime-requests.*') ? 'active' : '' }}"
           href="{{ route('admin.overtime-requests.index') }}">Pengajuan Lembur</a>
        <a class="collapse-item {{ request()->routeIs('admin.leave-requests.*') ? 'active' : '' }}"
           href="{{ route('admin.leave-requests.index') }}">Pengajuan Cuti & Izin</a>
        <a class="collapse-item {{ request()->routeIs('admin.attendance-summary.*') ? 'active' : '' }}"
           href="{{ route('admin.attendance-summary.index') }}">Ringkasan Presensi</a>
      </div>
    </div>
  </li>

  {{-- Payroll --}}
  <li class="nav-item {{ 
        request()->routeIs('admin.payroll.*') ||
        request()->routeIs('admin.tunjangan.*') ||
        request()->routeIs('admin.potongan.*') ||
        request()->routeIs('admin.employee-allowances.*') ||
        request()->routeIs('admin.employee-deductions.*') ||
        request()->routeIs('admin.setting_overtime.*')
      ? 'active' : '' }}">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePayroll"
       aria-expanded="{{ 
         request()->routeIs('admin.payroll.*') ||
         request()->routeIs('admin.tunjangan.*') ||
         request()->routeIs('admin.potongan.*') ||
         request()->routeIs('admin.employee-allowances.*') ||
         request()->routeIs('admin.employee-deductions.*') ||
         request()->routeIs('admin.setting_overtime.*')
       ? 'true' : 'false' }}"
       aria-controls="collapsePayroll">
      <i class="fas fa-fw fa-money-bill-wave"></i>
      <span>Payroll</span>
    </a>
    <div id="collapsePayroll"
         class="collapse {{ 
           request()->routeIs('admin.payroll.*') ||
           request()->routeIs('admin.tunjangan.*') ||
           request()->routeIs('admin.potongan.*') ||
           request()->routeIs('admin.employee-allowances.*') ||
           request()->routeIs('admin.employee-deductions.*') ||
           request()->routeIs('admin.setting_overtime.*')
         ? 'show' : '' }}"
         data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item {{ request()->routeIs('admin.payroll.index') ? 'active' : '' }}"
           href="{{ route('admin.payroll.index') }}">Data Payroll</a>
        <a class="collapse-item {{ request()->routeIs('admin.tunjangan.index') ? 'active' : '' }}"
           href="{{ route('admin.tunjangan.index') }}">Master Tunjangan</a>
        <a class="collapse-item {{ request()->routeIs('admin.potongan.index') ? 'active' : '' }}"
           href="{{ route('admin.potongan.index') }}">Master Potongan</a>
        <a class="collapse-item {{ request()->routeIs('admin.employee-allowances.*') ? 'active' : '' }}"
           href="{{ route('admin.employee-allowances.index') }}">Tunjangan Karyawan</a>
        <a class="collapse-item {{ request()->routeIs('admin.employee-deductions.*') ? 'active' : '' }}"
           href="{{ route('admin.employee-deductions.index') }}">Potongan Karyawan</a>
        <a class="collapse-item {{ request()->routeIs('admin.setting_overtime.edit') ? 'active' : '' }}"
           href="{{ route('admin.setting_overtime.edit') }}">Setting Lembur</a>
      </div>
    </div>
  </li>

  <hr class="sidebar-divider">

  {{-- Shift & Group --}}
  <li class="nav-item {{ request()->routeIs('admin.shifts.*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.shifts.index') }}">
      <i class="fas fa-fw fa-clock"></i>
      <span>Shift</span>
    </a>
  </li>
  <li class="nav-item {{ request()->routeIs('admin.shift-groups.*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.shift-groups.index') }}">
      <i class="fas fa-fw fa-users-cog"></i>
      <span>Group Shift</span>
    </a>
  </li>

  <hr class="sidebar-divider">

  {{-- Calendar --}}
  <li class="nav-item {{ request()->routeIs('admin.calendars.*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.calendars.index') }}">
      <i class="fas fa-fw fa-calendar-alt"></i>
      <span>Calendar</span>
    </a>
  </li>

  <hr class="sidebar-divider d-none d-md-block">

  {{-- Logout --}}
  <li class="nav-item">
    <a class="nav-link" href="#" onclick="event.preventDefault(); if (confirm('Anda yakin ingin logout?')) document.getElementById('logout-form').submit();">
      <i class="fas fa-fw fa-sign-out-alt"></i>
      <span>Logout</span>
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
  </li>

  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
