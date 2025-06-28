@extends('layouts.master')
@section('title','Daftar Payroll')
@section('content')
<div class="container-fluid">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Daftar Payroll</h4>
    <div>
      <form action="{{ route('admin.payroll.destroyAll') }}" method="POST" class="d-inline">
        @csrf @method('DELETE')
        <button class="btn btn-danger btn-sm">Hapus Semua</button>
      </form>
      <a href="{{ route('admin.payroll.create') }}" class="btn btn-primary btn-sm">+ Buat Payroll</a>
    </div>
  </div>
  <table class="table table-bordered table-hover">
    <thead class="thead-light">
      <tr>
        <th>No</th><th>Nama</th><th>Periode</th>
        <th>Gaji Pokok</th><th>Tunjangan</th>
        <th>Potongan</th><th>Lembur</th>
        <th>Net</th><th>Status</th><th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach($payrolls as $i=>$p)
      <tr>
        <td>{{ $i+1 }}</td>
        <td>{{ $p->employee->name }}</td>
        <td>{{ $p->start_date->format('Y-m') }}</td>
        <td>Rp {{ number_format($p->basic_salary,0,',','.') }}</td>
        <td>Rp {{ number_format($p->total_allowances,0,',','.') }}</td>
        <td>Rp {{ number_format($p->total_deductions,0,',','.') }}</td>
        <td>Rp {{ number_format($p->overtime_amount,0,',','.') }}</td>
        <td>Rp {{ number_format($p->net_salary,0,',','.') }}</td>
        <td>
          <span class="badge badge-{{ $p->status==='approved'?'success':'secondary' }}">
            {{ ucfirst($p->status) }}
          </span>
        </td>
        <td>
          <a href="{{ route('admin.payroll.show',$p) }}" class="btn btn-sm btn-info">Lihat</a>
          @if($p->status!=='approved')
          <form action="{{ route('admin.payroll.approve',$p->id) }}" method="POST" class="d-inline">
            @csrf @method('PATCH')
            <button class="btn btn-sm btn-success">Approve</button>
          </form>
          @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
