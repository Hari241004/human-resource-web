@extends('layouts.master')

@section('title','Recruit New Employee')

@section('content')
<div class="container-fluid">
  <div class="card shadow mb-4">
    <div class="card-header">
      <h6 class="text-primary">Recruit New Employee</h6>
    </div>
    <div class="card-body">
      <form id="recruit-form"
            action="{{ route('admin.recruitment.store') }}"
            method="POST"
            enctype="multipart/form-data">
        @csrf

        {{-- Name & NIK --}}
        <div class="row">
          <div class="form-group col-md-6">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan nama" required>
          </div>
          <div class="form-group col-md-6">
            <label for="nik">NIK</label>
            <input type="text" name="nik" id="nik" class="form-control" placeholder="Masukkan NIK" required>
          </div>
        </div>

        {{-- Title (Gelar) --}}
        <div class="form-group">
          <label for="title">Title</label>
          <input type="text" name="title" id="title" class="form-control" placeholder="Masukkan gelar (contoh: Dr., S.T., M.M.)" required>
        </div>

        {{-- Address --}}
        <div class="form-group">
          <label for="address">Address</label>
          <textarea name="address" id="address" class="form-control" rows="2" placeholder="Masukkan alamat lengkap" required></textarea>
        </div>

        {{-- Place & Date of Birth --}}
        <div class="row">
          <div class="form-group col-md-6">
            <label for="place_of_birth">Place of Birth</label>
            <input type="text" name="place_of_birth" id="place_of_birth" class="form-control" placeholder="Masukkan tempat lahir" required>
          </div>
          <div class="form-group col-md-6">
            <label for="date_of_birth">Date of Birth</label>
            <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" required>
          </div>
        </div>

        {{-- KK Number & Religion --}}
        <div class="row">
          <div class="form-group col-md-6">
            <label for="kk_number">No. KK</label>
            <input type="text" name="kk_number" id="kk_number" class="form-control" placeholder="Masukkan nomor KK" required>
          </div>
          <div class="form-group col-md-6">
            <label for="religion">Religion</label>
            <select name="religion" id="religion" class="form-control" required>
              <option value="" disabled selected>Pilih agama</option>
              <option>Islam</option>
              <option>Kristen</option>
              <option>Katolik</option>
              <option>Hindu</option>
              <option>Budha</option>
            </select>
          </div>
        </div>

        {{-- Gender & Contract End Date --}}
        <div class="row">
          <div class="form-group col-md-6">
            <label for="gender">Jenis Kelamin</label>
            <select name="gender" id="gender" class="form-control" required>
              <option value="" disabled selected>Pilih jenis kelamin</option>
              <option value="Laki-laki">Laki-laki</option>
              <option value="Perempuan">Perempuan</option>
            </select>
          </div>
          <div class="form-group col-md-6">
            <label for="contract_end_date">Contract End Date</label>
            <input type="date" name="contract_end_date" id="contract_end_date" class="form-control" required>
          </div>
        </div>

        {{-- Email & Password --}}
        <div class="row">
          <div class="form-group col-md-6">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan email" required>
          </div>
          <div class="form-group col-md-6">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
          </div>
        </div>

        {{-- Phone & Marital Status --}}
        <div class="row">
          <div class="form-group col-md-6">
            <label for="phone">Phone</label>
            <input type="text" name="phone" id="phone" class="form-control" placeholder="Masukkan nomor HP" required>
          </div>
          <div class="form-group col-md-6">
            <label for="marital_status">Marital Status</label>
            <select name="marital_status" id="marital_status" class="form-control" required>
              <option value="" disabled selected>Pilih status</option>
              <option>Sudah Kawin</option>
              <option>Belum Kawin</option>
            </select>
          </div>
        </div>

        {{-- Position & Education --}}
        <div class="row">
          <div class="form-group col-md-6">
            <label for="position">Position</label>
            <input type="text" name="position" id="position" class="form-control" placeholder="Masukkan jabatan" required>
          </div>
          <div class="form-group col-md-6">
            <label for="education">Education</label>
            <input type="text" name="education" id="education" class="form-control" placeholder="Masukkan pendidikan terakhir" required>
          </div>
        </div>

        {{-- TMT & Salary --}}
        <div class="row">
          <div class="form-group col-md-6">
            <label for="tmt">TMT</label>
            <input type="date" name="tmt" id="tmt" class="form-control" required>
          </div>
          <div class="form-group col-md-6">
            <label for="salary">Salary</label>
            <input type="number" name="salary" id="salary" class="form-control" placeholder="Masukkan gaji pokok" required>
          </div>
        </div>

        {{-- Photo --}}
        <div class="form-group">
          <label for="photo">Photo (JPG/PNG)</label>
          <input type="file" name="photo" id="photo" class="form-control-file" accept="image/jpeg,image/png">
        </div>

        <button type="submit" class="btn btn-success">Submit</button>
        <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
  {{-- SweetAlert2 --}}
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.getElementById('recruit-form').addEventListener('submit', function(e) {
      e.preventDefault();
      Swal.fire({
        title: 'Yakin ingin menambahkan user?',
        text: 'Data baru akan tersimpan ke database.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, simpan',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          this.submit();
        }
      });
    });
  </script>
@endpush