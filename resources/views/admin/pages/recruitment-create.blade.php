{{-- resources/views/admin/pages/recruitment-create.blade.php --}}
@extends('layouts.master')

@section('title','Tambah Recruitment')

@section('content')
<div class="container-fluid">

  {{-- Notifikasi sukses --}}
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Recruitment</h1>
    <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary btn-sm">
      <i class="fas fa-arrow-left"></i> Kembali
    </a>
  </div>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="card shadow mb-4">
    <div class="card-header bg-primary text-white">
      <h6 class="m-0 font-weight-bold">Form Data Recruitment</h6>
    </div>
    <div class="card-body">
      <form action="{{ route('admin.recruitment.store') }}"
            method="POST"
            enctype="multipart/form-data">
        @csrf

        <div class="row">
          <!-- Kolom Kiri -->
          <div class="col-md-6">
            <div class="form-group">
              <label><i class="fas fa-user text-primary mr-1"></i> Nama Lengkap</label>
              <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="form-group">
              <label><i class="fas fa-id-card text-primary mr-1"></i> NIK</label>
              <input type="text" name="nik" class="form-control" value="{{ old('nik') }}" required>
            </div>
            <div class="form-group">
              <label><i class="fas fa-phone text-primary mr-1"></i> Telepon</label>
              <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
            </div>
            <div class="form-group">
              <label><i class="fas fa-venus-mars text-primary mr-1"></i> Jenis Kelamin</label>
              <select name="gender" class="form-control" required>
                <option value="">-- Pilih Gender --</option>
                <option value="Laki-laki"  {{ old('gender')=='Laki-laki' ? 'selected':'' }}>Laki-laki</option>
                <option value="Perempuan"  {{ old('gender')=='Perempuan' ? 'selected':'' }}>Perempuan</option>
              </select>
            </div>
            <div class="form-group">
              <label><i class="fas fa-map-marker-alt text-primary mr-1"></i> Tempat Lahir</label>
              <input type="text" name="place_of_birth" class="form-control" value="{{ old('place_of_birth') }}" required>
            </div>
            <div class="form-group">
              <label><i class="fas fa-calendar-alt text-primary mr-1"></i> Tanggal Lahir</label>
              <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth') }}" required>
            </div>
            <div class="form-group">
              <label><i class="fas fa-id-card-alt text-primary mr-1"></i> No. KK</label>
              <input type="text" name="kk_number" class="form-control" value="{{ old('kk_number') }}" required>
            </div>
            <div class="form-group">
              <label><i class="fas fa-praying-hands text-primary mr-1"></i> Agama</label>
              <select name="religion" class="form-control" required>
                <option value="">-- Pilih Agama --</option>
                @foreach(['ISLAM','KRISTEN','KATHOLIK','HINDU','BUDDHA','KONG HU CHU'] as $r)
                  <option value="{{ $r }}" {{ old('religion')==$r ? 'selected':'' }}>{{ $r }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label><i class="fas fa-home text-primary mr-1"></i> Alamat</label>
              <textarea name="address" class="form-control" rows="3" required>{{ old('address') }}</textarea>
            </div>
          </div>

          <!-- Kolom Kanan -->
          <div class="col-md-6">
            <div class="form-group">
              <label><i class="fas fa-ring text-primary mr-1"></i> Status Perkawinan</label>
              <select name="marital_status" class="form-control" required>
                <option value="">-- Pilih Status --</option>
                <option value="Sudah Kawin"  {{ old('marital_status')=='Sudah Kawin' ? 'selected':'' }}>Sudah Kawin</option>
                <option value="Belum Kawin"  {{ old('marital_status')=='Belum Kawin' ? 'selected':'' }}>Belum Kawin</option>
              </select>
            </div>
            <div class="form-group">
              <label><i class="fas fa-graduation-cap text-primary mr-1"></i> Pendidikan</label>
              <input type="text" name="education" class="form-control" value="{{ old('education') }}" required>
            </div>
            <div class="form-group">
              <label><i class="fas fa-calendar-check text-primary mr-1"></i> TMT (Mulai Tugas)</label>
              <input type="date" name="tmt" class="form-control" value="{{ old('tmt') }}" required>
            </div>
            <div class="form-group">
              <label><i class="fas fa-calendar-times text-primary mr-1"></i> Tanggal Akhir Kontrak</label>
              <input type="date" name="contract_end_date" class="form-control" value="{{ old('contract_end_date') }}" required>
            </div>
            <div class="form-group">
              <label><i class="fas fa-money-bill-wave text-primary mr-1"></i> Gaji Pokok</label>
              <input type="number" name="salary" class="form-control" value="{{ old('salary') }}" required>
            </div>
            <div class="form-group">
              <label><i class="fas fa-user-tag text-primary mr-1"></i> Title</label>
              <input type="text" name="title" class="form-control" value="{{ old('title') }}">
            </div>
            <div class="form-group">
              <label><i class="fas fa-building text-primary mr-1"></i> Department</label>
              <select id="department-select" name="department_id" class="form-control" required>
                <option value="">-- Pilih Department --</option>
                @foreach($departments as $dept)
                  <option value="{{ $dept->id }}" {{ old('department_id')==$dept->id?'selected':'' }}>
                    {{ $dept->name }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label><i class="fas fa-briefcase text-primary mr-1"></i> Position</label>
              <select id="position-select" name="position_id" class="form-control" required>
                <option value="">-- Pilih Position --</option>
              </select>
            </div>
            <div class="form-group">
              <label><i class="fas fa-user-circle text-primary mr-1"></i> Nama Rekening</label>
              <input type="text" name="bank_account_name" class="form-control" value="{{ old('bank_account_name') }}" required>
            </div>
            <div class="form-group">
              <label><i class="fas fa-credit-card text-primary mr-1"></i> Nomor Rekening</label>
              <input type="text" name="bank_account_number" class="form-control" value="{{ old('bank_account_number') }}" required>
            </div>
            <div class="form-group">
              <label><i class="fas fa-image text-primary mr-1"></i> Upload Photo</label>
              <input type="file" name="photo" class="form-control-file" accept="image/jpeg,image/png">
            </div>
          </div>
        </div>

        {{-- Pembuatan User --}}
        <div class="card border-info mt-4">
          <div class="card-header bg-info text-white">
            <h6 class="m-0 font-weight-bold">
              <i class="fas fa-user-lock mr-1"></i> Pembuatan User
            </h6>
          </div>
          <div class="card-body">
            <div class="form-group">
              <label><i class="fas fa-envelope text-primary mr-1"></i> Email User</label>
              <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>
            <div class="form-group">
              <label><i class="fas fa-lock text-primary mr-1"></i> Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
          </div>
        </div>

        <div class="text-right mt-4">
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Simpan Recruitment
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  // deptPositions: { department_id: [ {id,name}, … ], … }
  const deptPositions = @json($deptPositions);

  document.addEventListener('DOMContentLoaded', () => {
    const deptSel = document.getElementById('department-select');
    const posSel  = document.getElementById('position-select');
    const oldDept = "{{ old('department_id') }}";
    const oldPos  = "{{ old('position_id') }}";

    function fill(deptId, selPos) {
      posSel.innerHTML = '<option value="">-- Pilih Position --</option>';
      (deptPositions[deptId]||[]).forEach(p => {
        const o = document.createElement('option');
        o.value = p.id;
        o.textContent = p.name;
        if (String(p.id) === String(selPos)) o.selected = true;
        posSel.appendChild(o);
      });
    }

    if (oldDept) fill(oldDept, oldPos);
    deptSel.addEventListener('change', e => fill(e.target.value, ''));
  });
</script>
@endpush
