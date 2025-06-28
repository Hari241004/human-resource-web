{{-- resources/views/employee/pages/overtime-requests-index.blade.php --}}
@extends('layouts.master')

@section('title','Riwayat Pengajuan Lembur')

@section('content')
<div class="container-fluid">
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h6 class="m-0 font-weight-bold text-primary">Riwayat Pengajuan Lembur</h6>
      <a href="{{ route('employee.overtime.requests.create') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i> Ajukan Lembur
      </a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Tanggal</th>
              <th>Mulai</th>
              <th>Selesai</th>
              <th>Alasan</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse($requests as $req)
              <tr>
                <td>{{ $requests->firstItem() + $loop->index }}</td>
                <td>{{ \Carbon\Carbon::parse($req->date)->format('d M Y') }}</td>
                <td>{{ $req->start_time }}</td>
                <td>{{ $req->end_time }}</td>
                <td>{{ $req->reason ?? '—' }}</td>
                <td>
                  @if($req->status === 'approved')
                    <span class="badge badge-success">Disetujui</span>
                  @elseif($req->status === 'rejected')
                    <span class="badge badge-danger">Ditolak</span>
                  @else
                    <span class="badge badge-warning">Pending</span>
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center">Belum ada pengajuan lembur.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="d-flex justify-content-center">
        {{ $requests->links('pagination::bootstrap-4') }}
      </div>
    </div>
  </div>
</div>
@endsection
