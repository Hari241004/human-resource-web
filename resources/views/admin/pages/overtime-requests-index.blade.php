@extends('layouts.master')

@section('title','Pengajuan Lembur')

@section('content')
<div class="container-fluid">
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h6 class="m-0 font-weight-bold text-primary">Daftar Pengajuan Lembur</h6>
      <div>
        <!-- Button Tambah -->
        <a href="{{ route('admin.overtime-requests.create') }}" class="btn btn-success btn-sm mr-2">
          <i class="fas fa-plus"></i> Tambah Pengajuan
        </a>

        <!-- Filter Status -->
        <form method="GET" class="form-inline d-inline">
          <select name="status" class="form-control mr-2">
            <option value="">-- Semua Status --</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
          </select>
          <button type="submit" class="btn btn-sm btn-primary">Filter</button>
          @if(request()->has('status'))
            <a href="{{ route('admin.overtime-requests.index') }}" class="btn btn-sm btn-secondary ml-2">Reset</a>
          @endif
        </form>
      </div>
    </div>

    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>No</th>
              <th>Pegawai</th>
              <th>Tanggal</th>
              <th>Diajukan Pada</th>
              <th>Jam Mulai</th>
              <th>Jam Selesai</th>
              <th>Alasan</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($overtimeRequests as $overtime)
              <tr>
                <td>{{ $loop->iteration + ($overtimeRequests->currentPage() - 1) * $overtimeRequests->perPage() }}</td>
                <td>{{ $overtime->employee->name }}</td>

                <!-- FORMAT TANGGAL: 18 Juni 2025 -->
                <td>
                  {{ \Carbon\Carbon::parse($overtime->date)
                      ->locale('id')
                      ->translatedFormat('j F Y') }}
                </td>

                <!-- Created_at tetap -->
                <td>
                  🕒 {{ \Carbon\Carbon::parse($overtime->created_at)
                       ->locale('id')
                       ->translatedFormat('d F Y, H:i') }}
                </td>

                <!-- FORMAT JAM: 15:00 -->
                <td>
                  {{ \Carbon\Carbon::parse($overtime->start_time)
                      ->format('H:i') }}
                </td>
                <td>
                  {{ \Carbon\Carbon::parse($overtime->end_time)
                      ->format('H:i') }}
                </td>

                <td>{{ $overtime->reason }}</td>
                <td>
                  <span class="badge badge-{{ $overtime->status == 'approved' ? 'success' : ($overtime->status == 'rejected' ? 'danger' : 'warning') }}">
                    {{ ucfirst($overtime->status) }}
                  </span>
                </td>
                <td>
                  @if($overtime->status == 'pending')
                    <form method="POST" action="{{ route('admin.overtime-requests.approve', $overtime->id) }}" class="d-inline">
                      @csrf
                      <button type="submit" class="btn btn-success btn-sm">Setujui</button>
                    </form>
                    <form method="POST" action="{{ route('admin.overtime-requests.reject', $overtime->id) }}" class="d-inline">
                      @csrf
                      <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                    </form>
                  @else
                    <em>Tindak lanjut selesai</em>
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="9" class="text-center text-muted py-4">
                  <i class="fas fa-info-circle fa-2x mb-2"></i>
                  <div>Belum ada pengajuan lembur</div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      {{ $overtimeRequests->withQueryString()->links() }}
    </div>
  </div>
</div>
@endsection
