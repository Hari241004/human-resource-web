@extends('layouts.master')

@section('title','Edit Employee')

@section('content')
<div class="container-fluid">

  {{-- Notifikasi sukses --}}
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Employee</h1>
    <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary btn-sm">
      <i class="fas fa-arrow-left"></i> Kembali
    </a>
  </div>

  @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="card shadow mb-4">
    <div class="card-header bg-primary text-white">
      <h6 class="m-0 font-weight-bold">Form Data Employee</h6>
    </div>
    <div class="card-body">
      <form action="{{ route('admin.employees.update', $employee) }}"
            method="POST"
            enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="row">
          {{-- Kolom Kiri --}}
          <div class="col-md-6">
            {{-- Nama Lengkap --}}
            <div class="form-group">
              <label><i class="fas fa-user text-primary mr-1"></i> Nama Lengkap</label>
              <input type="text" name="name" class="form-control"
                     value="{{ old('name', $employee->name) }}" required>
            </div>
            {{-- NIK --}}
            <div class="form-group">
              <label><i class="fas fa-id-card text-primary mr-1"></i> NIK</label>
              <input type="text" name="nik" class="form-control"
                     value="{{ old('nik', $employee->nik) }}" required>
            </div>
            {{-- Email --}}
            <div class="form-group">
              <label><i class="fas fa-envelope text-primary mr-1"></i> Email</label>
              <input type="email" name="email" class="form-control"
                     value="{{ old('email', $employee->email) }}" required>
            </div>
            {{-- Telepon --}}
            <div class="form-group">
              <label><i class="fas fa-phone text-primary mr-1"></i> Telepon</label>
              <input type="text" name="phone" class="form-control"
                     value="{{ old('phone', $employee->recruitment->phone) }}" required>
            </div>
            {{-- Jenis Kelamin --}}
            <div class="form-group">
              <label><i class="fas fa-venus-mars text-primary mr-1"></i> Jenis Kelamin</label>
              <select name="gender" class="form-control" required>
                <option value="Laki-laki" {{ old('gender', $employee->gender)=='Laki-laki'?'selected':'' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('gender', $employee->gender)=='Perempuan'?'selected':'' }}>Perempuan</option>
              </select>
            </div>
            {{-- Tempat Lahir --}}
            <div class="form-group">
              <label><i class="fas fa-map-marker-alt text-primary mr-1"></i> Tempat Lahir</label>
              <input type="text" name="place_of_birth" class="form-control"
                     value="{{ old('place_of_birth', $employee->recruitment->place_of_birth) }}" required>
            </div>
            {{-- Tanggal Lahir --}}
            <div class="form-group">
              <label><i class="fas fa-calendar-alt text-primary mr-1"></i> Tanggal Lahir</label>
              <input type="date" name="date_of_birth" class="form-control"
                     value="{{ old('date_of_birth', optional($employee->recruitment->date_of_birth)->format('Y-m-d')) }}" required>
            </div>
            {{-- No. KK --}}
            <div class="form-group">
              <label><i class="fas fa-id-card-alt text-primary mr-1"></i> No. KK</label>
              <input type="text" name="kk_number" class="form-control"
                     value="{{ old('kk_number', $employee->recruitment->kk_number) }}" required>
            </div>
            {{-- Agama --}}
            <div class="form-group">
              <label><i class="fas fa-praying-hands text-primary mr-1"></i> Agama</label>
              <select name="religion" class="form-control" required>
                @foreach(['ISLAM','KRISTEN','KATHOLIK','HINDU','BUDDHA','KONG HU CHU'] as $r)
                  <option value="{{ $r }}" {{ old('religion', $employee->recruitment->religion)==$r?'selected':'' }}>{{ $r }}</option>
                @endforeach
              </select>
            </div>
            {{-- Alamat --}}
            <div class="form-group">
              <label><i class="fas fa-home text-primary mr-1"></i> Alamat</label>
              <textarea name="address" class="form-control" rows="3" required>{{ old('address', $employee->recruitment->address) }}</textarea>
            </div>
          </div>

          {{-- Kolom Kanan --}}
          <div class="col-md-6">
            {{-- Status Perkawinan --}}
            <div class="form-group">
              <label><i class="fas fa-ring text-primary mr-1"></i> Status Perkawinan</label>
              <select name="marital_status" class="form-control" required>
                <option value="Sudah Kawin" {{ old('marital_status', $employee->recruitment->marital_status)=='Sudah Kawin'?'selected':'' }}>Sudah Kawin</option>
                <option value="Belum Kawin" {{ old('marital_status', $employee->recruitment->marital_status)=='Belum Kawin'?'selected':'' }}>Belum Kawin</option>
              </select>
            </div>
            {{-- Pendidikan --}}
            <div class="form-group">
              <label><i class="fas fa-graduation-cap text-primary mr-1"></i> Pendidikan</label>
              <input type="text" name="education" class="form-control"
                     value="{{ old('education', $employee->recruitment->education) }}" required>
            </div>
            {{-- TMT (Mulai Tugas) --}}
            <div class="form-group">
              <label><i class="fas fa-calendar-check text-primary mr-1"></i> TMT (Mulai Tugas)</label>
              <input type="date" name="tmt" class="form-control"
                     value="{{ old('tmt', optional($employee->recruitment->tmt)->format('Y-m-d')) }}" required>
            </div>
            {{-- Tanggal Akhir Kontrak --}}
            <div class="form-group">
              <label><i class="fas fa-calendar-times text-primary mr-1"></i> Tanggal Akhir Kontrak</label>
              <input type="date" name="contract_end_date" class="form-control"
                     value="{{ old('contract_end_date', optional($employee->recruitment->contract_end_date)->format('Y-m-d')) }}" required>
            </div>
            {{-- Gaji Pokok --}}
            <div class="form-group">
              <label><i class="fas fa-money-bill-wave text-primary mr-1"></i> Gaji Pokok</label>
              <input type="number" name="salary" class="form-control"
                     value="{{ old('salary', $employee->recruitment->salary) }}" required>
            </div>
            {{-- Title --}}
            <div class="form-group">
              <label><i class="fas fa-user-tag text-primary mr-1"></i> Title</label>
              <input type="text" name="title" class="form-control"
                     value="{{ old('title', $employee->title) }}">
            </div>
            {{-- Department → Position --}}
            <div class="form-group">
              <label><i class="fas fa-building text-primary mr-1"></i> Department</label>
              <select id="department-select" name="department_id" class="form-control" required>
                @foreach($departments as $dept)
                  <option value="{{ $dept->id }}" {{ old('department_id', $employee->department_id)==$dept->id?'selected':'' }}>{{ $dept->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label><i class="fas fa-briefcase text-primary mr-1"></i> Position</label>
              <select id="position-select" name="position_id" class="form-control" required>
                <!-- Options diisi lewat JS -->
              </select>
            </div>
            {{-- Bank --}}
            <div class="form-group">
              <label><i class="fas fa-user-circle text-primary mr-1"></i> Nama Rekening</label>
              <input type="text" name="bank_account_name" class="form-control"
                     value="{{ old('bank_account_name', $employee->bank_account_name) }}" required>
            </div>
            <div class="form-group">
              <label><i class="fas fa-credit-card text-primary mr-1"></i> Nomor Rekening</label>
              <input type="text" name="bank_account_number" class="form-control"
                     value="{{ old('bank_account_number', $employee->bank_account_number) }}" required>
            </div>
            {{-- Upload Photo --}}
            <div class="form-group">
              <label><i class="fas fa-image text-primary mr-1"></i> Upload Photo</label>
              <input type="file" name="photo" class="form-control-file" accept="image/jpeg,image/png">
              @if($employee->photo)
                <img src="{{ asset('storage/'.$employee->photo) }}" class="mt-2" style="max-width:150px; border-radius:4px;">
              @endif
            </div>
          </div>
        </div>

        <div class="text-right mt-4">
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Update Employee
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  const deptPositions = @json($deptPositions);

  document.addEventListener('DOMContentLoaded', () => {
    const deptSel = document.getElementById('department-select');
    const posSel = document.getElementById('position-select');
    const oldDept = "{{ old('department_id', $employee->department_id) }}";
    const oldPos  = "{{ old('position_id', $employee->position_id) }}";

    function fill(deptId, selPos) {
      posSel.innerHTML = '<option value="">-- Pilih Position --</option>';
      (deptPositions[deptId]||[]).forEach(p => {
        const o = new Option(p.name, p.id);
        if (String(p.id) === String(selPos)) o.selected = true;
        posSel.add(o);
      });
    }

    if (oldDept) fill(oldDept, oldPos);
    deptSel.addEventListener('change', e => fill(e.target.value, ''));
  });
</script>
@endpush
