{{-- resources/views/employee/pages/attendance-requests-index.blade.php --}}
@extends('layouts.master')

@section('title','Riwayat Pengajuan Presensi')

@section('content')
<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800">Riwayat Pengajuan Presensi</h1>

  <a href="{{ route('employee.presensi.requests.create') }}"
     class="btn btn-primary btn-sm mb-3">
    <i class="fas fa-plus"></i> Ajukan Baru
  </a>

  <div class="card shadow mb-4">
    <div class="card-body table-responsive">
      <table class="table table-bordered" width="100%">
        <thead class="thead-light">
          <tr>
            <th>No</th><th>Tanggal</th><th>Tipe</th><th>Alasan</th><th>Status</th>
          </tr>
        </thead>
        <tbody>
          @forelse($requests as $req)
            <tr>
              <td>{{ $requests->firstItem() + $loop->index }}</td>
              <td>{{ \Carbon\Carbon::parse($req->date)->format('d M Y') }}</td>
              <td>{{ ucfirst($req->type) }}</td>
              <td>{{ $req->reason ?? '—' }}</td>
              <td>
                @if($req->status==='approved')
                  <span class="badge badge-success">Disetujui</span>
                @elseif($req->status==='rejected')
                  <span class="badge badge-danger">Ditolak</span>
                @else
                  <span class="badge badge-warning">Menunggu</span>
                @endif
              </td>
            </tr>
          @empty
            <tr><td colspan="5" class="text-center">Belum ada pengajuan.</td></tr>
          @endforelse
        </tbody>
      </table>

      <div class="d-flex justify-content-center">
        {{ $requests->links('pagination::bootstrap-4') }}
      </div>
    </div>
  </div>
</div>
@endsection
