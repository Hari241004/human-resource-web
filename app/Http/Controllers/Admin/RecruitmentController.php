<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recruitment;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RecruitmentController extends Controller
{
    /**
     * Tampilkan halaman form untuk merekrut pegawai baru.
     */
    public function create()
    {
        return view('admin.pages.recruitment-create');
    }

    /**
     * Simpan data recruitment baru ke tabel recruitments,
     * lalu buat record di employees & users.
     */
    public function store(Request $request)
    {
        // 1. Validasi input
        $data = $request->validate([
            'name'               => 'required|string|max:255',
            'nik'                => 'required|string|unique:employees,nik',
            'email'              => 'required|email|unique:users,email|unique:employees,email',
            'password'           => 'required|string|min:6',
            'title'              => 'nullable|string|max:255',
            'address'            => 'required|string',
            'place_of_birth'     => 'required|string|max:255',
            'date_of_birth'      => 'required|date',
            'kk_number'          => 'required|string|max:255',
            'religion'           => 'required|string|max:100',
            'gender'             => 'required|in:Laki-laki,Perempuan',
            'contract_end_date'  => 'required|date|after_or_equal:tmt',
            'phone'              => 'required|string|max:20',
            'marital_status'     => 'required|in:Sudah Kawin,Belum Kawin',
            'position'           => 'required|string|max:255',
            'education'          => 'required|string|max:255',
            'tmt'                => 'required|date',
            'salary'             => 'required|numeric',
            'photo'              => 'nullable|mimes:jpg,jpeg,png|max:2048',
        ]);

        // 2. Tangani upload file foto
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')
                                    ->store('recruitments', 'public');
        }

        // 3. Simpan semua dalam transaction
        DB::beginTransaction();
        try {
            // a) Buat User
            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => Hash::make($data['password']),
                'photo'    => $data['photo'] ?? null,
                'role'     => 'user',
            ]);

            // b) Buat Employee (termasuk gender)
            $employee = Employee::create([
                'user_id'  => $user->id,
                'name'     => $data['name'],
                'nik'      => $data['nik'],
                'email'    => $data['email'],
                'position' => $data['position'],
                'title'    => $data['title'] ?? null,
                'gender'   => $data['gender'],
                'photo'    => $data['photo'] ?? null,
            ]);

            // c) Buat Recruitment (termasuk gender & contract_end_date)
            Recruitment::create([
                'user_id'           => $user->id,
                'employee_id'       => $employee->id,
                'address'           => $data['address'],
                'place_of_birth'    => $data['place_of_birth'],
                'date_of_birth'     => $data['date_of_birth'],
                'kk_number'         => $data['kk_number'],
                'religion'          => $data['religion'],
                'gender'            => $data['gender'],
                'contract_end_date' => $data['contract_end_date'],
                'email'             => $data['email'],
                'password'          => Hash::make($data['password']),
                'phone'             => $data['phone'],
                'marital_status'    => $data['marital_status'],
                'education'         => $data['education'],
                'tmt'               => $data['tmt'],
                'salary'            => $data['salary'],
                'photo'             => $data['photo'] ?? null,
            ]);

            DB::commit();

            return redirect()
                ->route('admin.employees.index')
                ->with('success', 'Rekrutmen berhasil, semua data tersimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'Gagal menyimpan data: ' . $e->getMessage()
            ])->withInput();
        }
    }
}
