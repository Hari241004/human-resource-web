{{-- resources/views/admin/pages/leave-requests.blade.php --}}
@extends('layouts.master')

@section('title','Daftar Pengajuan Cuti')

@section('content')
<div class="container-fluid">
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
  @endif

  <div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h6 class="m-0 font-weight-bold text-primary">Daftar Pengajuan Cuti</h6>

      <form method="GET" class="form-inline">
        <div class="input-group mr-2">
          <input type="text" name="search" class="form-control form-control-sm"
                 placeholder="Cari nama/NIK..." value="{{ request('search','') }}">
          <div class="input-group-append">
            <button class="btn btn-outline-secondary btn-sm" type="submit">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>

        <div class="form-group mr-2">
          <select name="status" class="form-control form-control-sm">
            <option value="">-- Semua Status --</option>
            <option value="pending"  {{ request('status')=='pending'  ? 'selected':'' }}>Pending</option>
            <option value="approved" {{ request('status')=='approved' ? 'selected':'' }}>Disetujui</option>
            <option value="rejected" {{ request('status')=='rejected' ? 'selected':'' }}>Ditolak</option>
          </select>
        </div>

        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
        @if(request()->hasAny(['search','status']))
          <a href="{{ route('admin.leave-requests.index') }}"
             class="btn btn-secondary btn-sm ml-2">Reset</a>
        @endif
      </form>
    </div>

    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" width="100%">
          <thead class="thead-light">
            <tr>
              <th style="width:5%">No</th>
              <th>Pegawai</th>
              <th>Jenis</th>
              <th>Tanggal</th>
              <th>Alasan</th>
              <th>Status</th>
              <th>Reviewer</th>
              <th style="width:15%">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($leaveRequests as $leave)
              <tr>
                <td>{{ $leaveRequests->firstItem() + $loop->index }}</td>
                <td>{{ $leave->employee->name }}<br><small>{{ $leave->employee->nik }}</small></td>
                <td>{{ ucfirst($leave->type) }}</td>
                <td>{{ \Carbon\Carbon::parse($leave->start_date)->format('d M Y') }}
                    s.d 
                    {{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}</td>
                <td>{{ $leave->reason ?? '—' }}</td>
                <td>
                  <span class="badge badge-{{ $leave->status=='approved'?'success':($leave->status=='rejected'?'danger':'warning') }}">
                    {{ ucfirst($leave->status) }}
                  </span>
                </td>
                <td>
                  {{ $leave->status!='pending'
                     ? optional($leave->reviewer)->name ?? '-'
                     : 'Belum direview' }}
                </td>
                <td>
                  @if($leave->status=='pending')
                    <form action="{{ route('admin.leave-requests.approve', $leave->id) }}"
                          method="POST" class="d-inline">
                      @csrf @method('PATCH')
                      <button class="btn btn-success btn-sm">Setujui</button>
                    </form>
                    <form action="{{ route('admin.leave-requests.reject', $leave->id) }}"
                          method="POST" class="d-inline">
                      @csrf @method('PATCH')
                      <button class="btn btn-danger btn-sm">Tolak</button>
                    </form>
                  @else
                    <em>Selesai</em>
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="text-center">Tidak ada pengajuan.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{-- Pagination --}}
      <div class="d-flex justify-content-center">
        {{ $leaveRequests
            ->appends(request()->only(['search','status']))
            ->links('pagination::bootstrap-4') }}
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
.pagination .page-link {
  padding: 0.25rem 0.5rem;
  font-size: 0.875rem;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.querySelectorAll('button.btn-success, button.btn-danger').forEach(btn => {
    btn.addEventListener('click', e => {
      e.preventDefault();
      const form = btn.closest('form');
      const action = btn.textContent.trim().toLowerCase();
      Swal.fire({
        title: `Yakin ingin ${action}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal'
      }).then(res => {
        if (res.isConfirmed) form.submit();
      });
    });
  });
</script>
@endpush
