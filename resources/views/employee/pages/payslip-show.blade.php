@extends('layouts.master')
@section('title','Detail Payslip')
@section('content')
<div class="container-fluid">
  <a href="{{ route('employee.payslip.index') }}" class="btn btn-sm btn-secondary mb-3">← Kembali</a>
  <div class="card">
    <div class="card-body">
      <h5>Payslip {{ $payroll->start_date->format('Y-m') }}</h5>
      <p>Gaji Pokok: Rp {{ number_format($payroll->basic_salary,0,',','.') }}</p>
      <p>Total Tunjangan: Rp {{ number_format($payroll->total_allowances,0,',','.') }}</p>
      <p>Total Potongan: Rp {{ number_format($payroll->total_deductions,0,',','.') }}</p>
      <p>Total Lembur: Rp {{ number_format($payroll->overtime_amount,0,',','.') }}</p>
      <hr>
      <h6>Detail Komponen:</h6>
      <ul class="list-group">
        @foreach($payroll->details as $d)
          <li class="list-group-item d-flex justify-content-between">
            {{ ucfirst($d->component_type) }} – {{ $d->component_name }}
            <span>Rp {{ number_format($d->amount,0,',','.') }}</span>
          </li>
        @endforeach
      </ul>
      <hr>
      <h5>Total Take Home: Rp {{ number_format($payroll->net_salary,0,',','.') }}</h5>
      <a href="{{ route('employee.payslip.pdf',$payroll) }}" class="btn btn-sm btn-secondary mt-3">Download PDF</a>
    </div>
  </div>
</div>
@endsection
