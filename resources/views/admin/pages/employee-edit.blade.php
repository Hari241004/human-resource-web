@extends('layouts.master')

@section('title','Edit Data Pegawai')

@section('content')
<div class="container-fluid">
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="card shadow mb-4">
    <div class="card-header">
      <h6 class="text-primary">Edit Data Pegawai</h6>
    </div>
    <div class="card-body">
      <form id="edit-form"
            action="{{ route('admin.employees.update', $employee->id) }}"
            method="POST"
            enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- === DATA EMPLOYEE === --}}
        <div class="row">
          <div class="form-group col-md-6">
            <label for="name">Name</label>
            <input type="text"
                   name="name"
                   id="name"
                   class="form-control"
                   value="{{ old('name', $employee->name) }}"
                   required>
          </div>
          <div class="form-group col-md-6">
            <label for="nik">NIK</label>
            <input type="text"
                   name="nik"
                   id="nik"
                   class="form-control"
                   value="{{ old('nik', $employee->nik) }}"
                   required>
          </div>
        </div>

        <div class="row">
          <div class="form-group col-md-6">
            <label for="title">Title</label>
            <input type="text"
                   name="title"
                   id="title"
                   class="form-control"
                   placeholder="Dr., S.T., M.M."
                   value="{{ old('title', $employee->title) }}">
          </div>
          <div class="form-group col-md-6">
            <label for="position">Position</label>
            <input type="text"
                   name="position"
                   id="position"
                   class="form-control"
                   value="{{ old('position', $employee->position) }}"
                   required>
          </div>
        </div>

        <div class="row">
          <div class="form-group col-md-6">
            <label for="email">Email</label>
            <input type="email"
                   name="email"
                   id="email"
                   class="form-control"
                   value="{{ old('email', $employee->email) }}"
                   required>
          </div>
          <div class="form-group col-md-6">
            <label for="password">Password <small class="text-muted">(kosongkan jika tidak diubah)</small></label>
            <input type="password"
                   name="password"
                   id="password"
                   class="form-control"
                   placeholder="Masukkan password baru jika ingin ganti">
          </div>
        </div>

        <hr>

        {{-- === DATA RECRUITMENT === --}}
        @php $r = old('address') ? (object) old() : $employee->recruitment; @endphp

        <div class="form-group">
          <label for="address">Address</label>
          <textarea name="address"
                    id="address"
                    class="form-control"
                    rows="2"
                    required>{{ $r->address }}</textarea>
        </div>

        <div class="row">
          <div class="form-group col-md-6">
            <label for="place_of_birth">Place of Birth</label>
            <input type="text"
                   name="place_of_birth"
                   id="place_of_birth"
                   class="form-control"
                   value="{{ $r->place_of_birth }}"
                   required>
          </div>
          <div class="form-group col-md-6">
            <label for="date_of_birth">Date of Birth</label>
            <input type="date"
                   name="date_of_birth"
                   id="date_of_birth"
                   class="form-control"
                   value="{{ $r->date_of_birth }}"
                   required>
          </div>
        </div>

        <div class="row">
          <div class="form-group col-md-6">
            <label for="kk_number">No. KK</label>
            <input type="text"
                   name="kk_number"
                   id="kk_number"
                   class="form-control"
                   value="{{ $r->kk_number }}"
                   required>
          </div>
          <div class="form-group col-md-6">
            <label for="religion">Religion</label>
            <select name="religion"
                    id="religion"
                    class="form-control"
                    required>
              <option value="" disabled {{ $r->religion ? '' : 'selected' }}>Pilih agama</option>
              @foreach(['Islam','Kristen','Katolik','Hindu','Budha'] as $agama)
                <option value="{{ $agama }}"
                        {{ $r->religion === $agama ? 'selected' : '' }}>
                  {{ $agama }}
                </option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="row">
          <div class="form-group col-md-6">
            <label for="phone">Phone</label>
            <input type="text"
                   name="phone"
                   id="phone"
                   class="form-control"
                   value="{{ $r->phone }}"
                   required>
          </div>
          <div class="form-group col-md-6">
            <label for="marital_status">Marital Status</label>
            <select name="marital_status"
                    id="marital_status"
                    class="form-control"
                    required>
              <option value="" disabled {{ $r->marital_status ? '' : 'selected' }}>Pilih status</option>
              @foreach(['Sudah Kawin','Belum Kawin'] as $st)
                <option value="{{ $st }}"
                        {{ $r->marital_status === $st ? 'selected' : '' }}>
                  {{ $st }}
                </option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="row">
          <div class="form-group col-md-4">
            <label for="education">Education</label>
            <input type="text"
                   name="education"
                   id="education"
                   class="form-control"
                   value="{{ $r->education }}"
                   required>
          </div>
          <div class="form-group col-md-4">
            <label for="tmt">TMT</label>
            <input type="date"
                   name="tmt"
                   id="tmt"
                   class="form-control"
                   value="{{ $r->tmt }}"
                   required>
          </div>
          <div class="form-group col-md-4">
            <label for="contract_end_date">Contract End Date</label>
            <input type="date"
                   name="contract_end_date"
                   id="contract_end_date"
                   class="form-control"
                   value="{{ $r->contract_end_date }}"
                   required>
          </div>
        </div>

        <div class="form-group">
          <label for="salary">Salary</label>
          <input type="number"
                 name="salary"
                 id="salary"
                 class="form-control"
                 value="{{ $r->salary }}"
                 required>
        </div>

        {{-- Foto Preview (3:4) setelah Salary --}}
        @if($employee->photo)
          <div class="form-group">
            <label>Current Photo</label>
            <div style="width:75px; height:100px; overflow:hidden; border-radius:4px;" class="mb-3">
              <img src="{{ asset('storage/'.$employee->photo) }}"
                   alt="Foto {{ $employee->name }}"
                   style="width:100%; height:100%; object-fit:cover;">
            </div>
          </div>
        @endif

        <div class="form-group">
          <label for="photo">Photo (JPG/PNG) <small class="text-muted">(kosongkan jika tidak ganti)</small></label>
          <input type="file"
                 name="photo"
                 id="photo"
                 class="form-control-file"
                 accept="image/jpeg,image/png">
        </div>

        <button type="submit" class="btn btn-success">Update</button>
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
    document.getElementById('edit-form').addEventListener('submit', function(e) {
      e.preventDefault();
      Swal.fire({
        title: 'Yakin data akan diubah?',
        text: 'Perubahan ini tidak dapat dibatalkan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, ubah',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          this.submit();
        }
      });
    });
  </script>
@endpush