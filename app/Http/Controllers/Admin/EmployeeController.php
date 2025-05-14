<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the employees.
     */
    public function index()
    {
        $employees = Employee::with('recruitment')->orderBy('name')->get();
        return view('admin.pages.employee', compact('employees'));
    }

    /**
     * Display the specified employee.
     */
    public function show(Employee $employee)
    {
        $employee->load('recruitment');
        return view('admin.pages.employee-show', compact('employee'));
    }

    /**
     * Show the form for editing the specified employee.
     */
    public function edit(Employee $employee)
    {
        $employee->load('recruitment');
        return view('admin.pages.employee-edit', compact('employee'));
    }

    /**
     * Update the specified employee in storage, plus linked user & recruitment.
     */
    public function update(Request $request, Employee $employee)
    {
        // 1) Validasi input, termasuk gender & contract_end_date
        $data = $request->validate([
            'name'               => 'required|string|max:255',
            'nik'                => [
                                     'required', 'string', 'max:255',
                                     Rule::unique('employees','nik')->ignore($employee->id)
                                   ],
            'email'              => [
                                     'required', 'email',
                                     Rule::unique('users','email')->ignore($employee->user_id),
                                     Rule::unique('employees','email')->ignore($employee->id)
                                   ],
            'password'           => 'nullable|string|min:6',
            'title'              => 'nullable|string|max:255',
            'position'           => 'required|string|max:255',
            'gender'             => 'required|in:Laki-laki,Perempuan',
            'address'            => 'required|string',
            'place_of_birth'     => 'required|string',
            'date_of_birth'      => 'required|date',
            'kk_number'          => 'required|string',
            'religion'           => 'required|string',
            'phone'              => 'required|string',
            'marital_status'     => ['required', Rule::in(['Sudah Kawin','Belum Kawin'])],
            'education'          => 'required|string',
            'tmt'                => 'required|date',
            'contract_end_date'  => 'required|date|after_or_equal:tmt',
            'salary'             => 'required|numeric',
            'photo'              => 'nullable|mimes:jpg,jpeg,png|max:2048',
        ]);

        // 2) Handle upload foto baru (jika ada)
        if ($request->hasFile('photo')) {
            if ($employee->photo) {
                Storage::disk('public')->delete($employee->photo);
            }
            $data['photo'] = $request->file('photo')->store('employees', 'public');
        }

        DB::beginTransaction();
        try {
            // 3.1) Update tabel users
            $userUpdates = [
                'name'  => $data['name'],
                'email' => $data['email'],
            ];
            if (!empty($data['password'])) {
                $userUpdates['password'] = Hash::make($data['password']);
            }
            if (isset($data['photo'])) {
                $userUpdates['photo'] = $data['photo'];
            }
            $employee->user->update($userUpdates);

            // 3.2) Update tabel employees, termasuk gender
            $empUpdates = [
                'name'     => $data['name'],
                'nik'      => $data['nik'],
                'email'    => $data['email'],
                'position' => $data['position'],
                'title'    => $data['title'] ?? null,
                'gender'   => $data['gender'],
            ];
            if (isset($data['photo'])) {
                $empUpdates['photo'] = $data['photo'];
            }
            $employee->update($empUpdates);

            // 3.3) Update tabel recruitments, termasuk gender & contract_end_date
            $recUpdates = [
                'address'            => $data['address'],
                'place_of_birth'     => $data['place_of_birth'],
                'date_of_birth'      => $data['date_of_birth'],
                'kk_number'          => $data['kk_number'],
                'religion'           => $data['religion'],
                'gender'             => $data['gender'],
                'contract_end_date'  => $data['contract_end_date'],
                'email'              => $data['email'],
                'phone'              => $data['phone'],
                'marital_status'     => $data['marital_status'],
                'education'          => $data['education'],
                'tmt'                => $data['tmt'],
                'salary'             => $data['salary'],
            ];
            if (!empty($data['password'])) {
                $recUpdates['password'] = Hash::make($data['password']);
            }
            if (isset($data['photo'])) {
                $recUpdates['photo'] = $data['photo'];
            }
            $employee->recruitment->update($recUpdates);

            DB::commit();

            return redirect()
                ->route('admin.employees.index')
                ->with('success', 'Data pegawai berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withErrors(['error' => 'Gagal update: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Remove the specified employee from storage.
     */
    public function destroy(Employee $employee)
    {
        if ($employee->photo) {
            Storage::disk('public')->delete($employee->photo);
        }

        // cascade delete user & recruitment via foreign keys
        $employee->delete();

        return redirect()
            ->route('admin.employees.index')
            ->with('success', 'Pegawai berhasil dihapus.');
    }
}
