{{-- resources/views/admin/pages/employee-show.blade.php --}}
@extends('layouts.master')

@section('title','Detail Employee')

@section('content')
<div class="container-fluid">

  <div class="d-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 text-gray-800">Detail Employee</h1>
    <a href="{{ route('admin.employees.index') }}" class="btn btn-sm btn-secondary">
      <i class="fas fa-arrow-left"></i> Kembali
    </a>
  </div>

  <div class="card shadow-sm rounded-lg mb-4">
    <div class="card-body">
      <div class="row">
        {{-- Photo --}}
        <div class="col-lg-4 text-center">
          @if($employee->photo)
            <img 
              src="{{ asset('storage/'.$employee->photo) }}"
              alt="Photo of {{ $employee->name }}"
              class="img-fluid rounded-lg mb-4"
              style="width:240px; height:320px; object-fit:cover; box-shadow:0 2px 6px rgba(0,0,0,0.2);">
          @else
            <div 
              class="bg-light d-flex align-items-center justify-content-center rounded-lg mb-4"
              style="width:240px; height:320px; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
              <span class="text-muted">No Photo</span>
            </div>
          @endif
        </div>

        {{-- Details --}}
        <div class="col-lg-8">
          <dl class="row mb-0 text-gray-800">
            <dt class="col-sm-4">Nama Lengkap</dt>
            <dd class="col-sm-8">{{ $employee->name }}</dd>

            <dt class="col-sm-4">NIK</dt>
            <dd class="col-sm-8">{{ $employee->nik }}</dd>

            <dt class="col-sm-4">Email</dt>
            <dd class="col-sm-8">{{ $employee->email }}</dd>

            <dt class="col-sm-4">Telepon</dt>
            <dd class="col-sm-8">{{ optional($employee->recruitment)->phone ?? '-' }}</dd>

            <dt class="col-sm-4">Jenis Kelamin</dt>
            <dd class="col-sm-8">
              <span class="badge badge-{{ $employee->gender=='Laki-laki'?'primary':'warning' }}">
                {{ $employee->gender }}
              </span>
            </dd>

            <dt class="col-sm-4">Department</dt>
            <dd class="col-sm-8">{{ $employee->department->name ?? '-' }}</dd>

            <dt class="col-sm-4">Position</dt>
            <dd class="col-sm-8">{{ $employee->position->name ?? '-' }}</dd>

            <dt class="col-sm-4">Title</dt>
            <dd class="col-sm-8">{{ $employee->title ?? '-' }}</dd>

            <dt class="col-sm-4">Tempat/Tgl Lahir</dt>
            <dd class="col-sm-8">
              {{ $employee->recruitment->place_of_birth ?? '-' }},
              {{ optional($employee->recruitment)->date_of_birth
                  ? \Carbon\Carbon::parse($employee->recruitment->date_of_birth)->format('d M Y')
                  : '-' }}
            </dd>

            <dt class="col-sm-4">TMT</dt>
            <dd class="col-sm-8">
              {{ optional($employee->recruitment)->tmt
                  ? \Carbon\Carbon::parse($employee->recruitment->tmt)->format('d M Y')
                  : '-' }}
            </dd>

            <dt class="col-sm-4">Akhir Kontrak</dt>
            <dd class="col-sm-8">
              {{ optional($employee->recruitment)->contract_end_date
                  ? \Carbon\Carbon::parse($employee->recruitment->contract_end_date)->format('d M Y')
                  : '-' }}
            </dd>

            <dt class="col-sm-4">Gaji Pokok</dt>
            <dd class="col-sm-8">
              {{ optional($employee->recruitment)->salary
                  ? 'Rp '.number_format($employee->recruitment->salary,0,',','.')
                  : '-' }}
            </dd>

            <dt class="col-sm-4">Rekening</dt>
            <dd class="col-sm-8">
              {{ $employee->bank_account_name ?? '-' }} / {{ $employee->bank_account_number ?? '-' }}
            </dd>
          </dl>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
