<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recruitment;
use App\Models\Employee;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RecruitmentController extends Controller
{
    /**
     * Show form untuk menambah rekrutmen baru.
     */
    public function create()
    {
        $departments = Department::with('positions')->get();
        $deptPositions = $departments
            ->mapWithKeys(fn($dept) => [
                $dept->id => $dept->positions
                    ->map(fn($pos) => ['id' => $pos->id, 'name' => $pos->name])
                    ->all()
            ])
            ->all();

        return view('admin.pages.recruitment-create', compact('departments', 'deptPositions'));
    }

    /**
     * Simpan data rekrutmen baru.
     */
    public function store(Request $request)
    {
        // Validasi input
        $data = $request->validate([
            'name'                => 'required|string|max:255',
            'nik'                 => 'required|string|unique:employees,nik',
            'email'               => 'required|email|unique:users,email|unique:employees,email',
            'password'            => 'required|string|min:6',
            'title'               => 'nullable|string|max:255',
            'address'             => 'required|string',
            'place_of_birth'      => 'required|string|max:255',
            'date_of_birth'       => 'required|date',
            'kk_number'           => 'required|string|max:255',
            'religion'            => 'required|string|max:100',
            'gender'              => 'required|in:Laki-laki,Perempuan',
            'department_id'       => 'required|exists:departments,id',
            'position_id'         => 'required|exists:positions,id',
            'tmt'                 => 'required|date',
            'contract_end_date'   => 'required|date|after_or_equal:tmt',
            'phone'               => 'required|string|max:20',
            'marital_status'      => 'required|in:Sudah Kawin,Belum Kawin',
            'education'           => 'required|string|max:255',
            'salary'              => 'required|numeric',
            'photo'               => 'nullable|mimes:jpg,jpeg,png|max:2048',
            'bank_account_name'   => 'required|string|max:255',
            'bank_account_number' => 'required|string|max:50',
        ]);

        // Debug: pastikan 'phone' dikirim
        // dd($data);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('recruitments', 'public');
        }

        DB::transaction(function() use ($data) {
            // 1) Buat User
            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => Hash::make($data['password']),
                'photo'    => $data['photo'] ?? null,
                'role'     => 'user',
            ]);

            // 2) Buat Employee
            $employee = Employee::create([
                'user_id'             => $user->id,
                'name'                => $data['name'],
                'nik'                 => $data['nik'],
                'email'               => $data['email'],
                'gender'              => $data['gender'],
                'title'               => $data['title'] ?? null,
                'photo'               => $data['photo'] ?? null,
                'date_of_birth'       => $data['date_of_birth'],
                'tmt'                 => $data['tmt'],
                'contract_end_date'   => $data['contract_end_date'],
                'phone'               => $data['phone'],            // <- pastikan ini ada
                'department_id'       => $data['department_id'],
                'position_id'         => $data['position_id'],
                'bank_account_name'   => $data['bank_account_name'],
                'bank_account_number' => $data['bank_account_number'],
            ]);

            // 3) Buat Recruitment
            Recruitment::create([
                'user_id'             => $user->id,
                'employee_id'         => $employee->id,
                'name'                => $data['name'],
                'nik'                 => $data['nik'],
                'email'               => $data['email'],
                'password'            => Hash::make($data['password']),
                'phone'               => $data['phone'],
                'gender'              => $data['gender'],
                'place_of_birth'      => $data['place_of_birth'],
                'date_of_birth'       => $data['date_of_birth'],
                'kk_number'           => $data['kk_number'],
                'religion'            => $data['religion'],
                'address'             => $data['address'],
                'marital_status'      => $data['marital_status'],
                'education'           => $data['education'],
                'tmt'                 => $data['tmt'],
                'contract_end_date'   => $data['contract_end_date'],
                'salary'              => $data['salary'],
                'photo'               => $data['photo'] ?? null,
                'department_id'       => $data['department_id'],
                'position_id'         => $data['position_id'],
                'title'               => $data['title'] ?? null,
                'bank_account_name'   => $data['bank_account_name'],
                'bank_account_number' => $data['bank_account_number'],
            ]);
        });

        // Setelah sukses, redirect ke daftar pegawai
        return redirect()->route('admin.employees.index')
                         ->with('success', 'Rekrutmen berhasil ditambahkan!');
    }
}
