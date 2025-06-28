{{-- resources/views/employee/pages/leave-requests-index.blade.php --}}
@extends('layouts.master')

@section('title','Pengajuan Cuti Saya')

@section('content')
<div class="container-fluid">
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h6 class="m-0 font-weight-bold text-primary">Daftar Pengajuan Cuti</h6>
      <a href="{{ route('employee.cuti.request') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i> Ajukan Cuti
      </a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Mulai</th>
              <th>Selesai</th>
              <th>Tipe</th>
              <th>Alasan</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse($leaveRequests as $req)
              <tr>
                <td>{{ $leaveRequests->firstItem() + $loop->index }}</td>
                <td>{{ \Carbon\Carbon::parse($req->start_date)->format('d M Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($req->end_date)->format('d M Y') }}</td>
                <td>{{ ucfirst($req->type) }}</td>
                <td>{{ $req->reason ?? '—' }}</td>
                <td>
                  @if($req->status === 'approved')
                    <span class="badge badge-success">Disetujui</span>
                  @elseif($req->status === 'rejected')
                    <span class="badge badge-danger">Ditolak</span>
                  @else
                    <span class="badge badge-warning">Menunggu</span>
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center">Belum ada pengajuan cuti.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="d-flex justify-content-center">
        {{ $leaveRequests->links('pagination::bootstrap-4') }}
      </div>
    </div>
  </div>
</div>
@endsection
