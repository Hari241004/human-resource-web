<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query  = Employee::with('recruitment');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nik',  'like', "%{$search}%")
                  ->orWhere('email','like', "%{$search}%");
            });
        }

        $employees = $query->orderBy('name')
                           ->paginate(10)
                           ->withQueryString();

        return view('admin.pages.employee', compact('employees', 'search'));
    }

    public function show(Employee $employee)
    {
        $employee->load('recruitment');
        return view('admin.pages.employee-show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $departments = Department::with('positions')->get();

        $deptPositions = $departments
            ->mapWithKeys(fn($d) => [
                $d->id => $d->positions
                    ->map(fn($p) => ['id' => $p->id, 'name' => $p->name])
                    ->all()
            ])
            ->toArray();

        return view('admin.pages.employee-edit', compact(
            'employee',
            'departments',
            'deptPositions'
        ));
    }

    public function update(Request $request, Employee $employee)
    {
        $data = $request->validate([
            'name'                => 'required|string|max:255',
            'nik'                 => ['required','string','max:255', Rule::unique('employees','nik')->ignore($employee->id)],
            'email'               => ['required','email', Rule::unique('users','email')->ignore($employee->user_id), Rule::unique('employees','email')->ignore($employee->id)],
            'password'            => 'nullable|string|min:6',
            'title'               => 'nullable|string|max:255',
            'department_id'       => 'required|exists:departments,id',
            'position_id'         => 'required|exists:positions,id',
            'gender'              => 'required|in:Laki-laki,Perempuan',
            'address'             => 'required|string',
            'place_of_birth'      => 'required|string',
            'date_of_birth'       => 'required|date',
            'kk_number'           => 'required|string',
            'religion'            => 'required|string',
            'phone'               => 'required|string',
            'marital_status'      => ['required', Rule::in(['Sudah Kawin','Belum Kawin'])],
            'education'           => 'required|string',
            'tmt'                 => 'required|date',
            'contract_end_date'   => 'required|date|after_or_equal:tmt',
            'salary'              => 'required|numeric',
            'photo'               => 'nullable|mimes:jpg,jpeg,png|max:2048',
            'bank_account_name'   => 'required|string|max:255',
            'bank_account_number' => 'required|string|max:50',
        ], [
            'contract_end_date.after_or_equal' => 'The Contract End Date must be a date after or equal to the TMT date.',
        ]);

        if ($request->hasFile('photo')) {
            if ($employee->photo) {
                Storage::disk('public')->delete($employee->photo);
            }
            $data['photo'] = $request->file('photo')->store('employees','public');
            Log::info('Photo updated', ['path' => $data['photo']]);
        }

        DB::beginTransaction();

        try {
            // 1) Update User
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

            // 2) Update Employee
            $empUpdates = [
                'name'                => $data['name'],
                'nik'                 => $data['nik'],
                'email'               => $data['email'],
                'gender'              => $data['gender'],
                'date_of_birth'       => $data['date_of_birth'],
                'tmt'                 => $data['tmt'],
                'contract_end_date'   => $data['contract_end_date'],
                'department_id'       => $data['department_id'],
                'position_id'         => $data['position_id'],
                'title'               => $data['title'] ?? null,
                'bank_account_name'   => $data['bank_account_name'],
                'bank_account_number' => $data['bank_account_number'],
            ];
            if (isset($data['photo'])) {
                $empUpdates['photo'] = $data['photo'];
            }
            $employee->update($empUpdates);

            // 3) Update Recruitment
            $rec = $employee->recruitment;
            $recUpdates = [
                'address'             => $data['address'],
                'place_of_birth'      => $data['place_of_birth'],
                'date_of_birth'       => $data['date_of_birth'],
                'kk_number'           => $data['kk_number'],
                'religion'            => $data['religion'],
                'gender'              => $data['gender'],
                'department_id'       => $data['department_id'],
                'position_id'         => $data['position_id'],
                'tmt'                 => $data['tmt'],
                'contract_end_date'   => $data['contract_end_date'],
                'email'               => $data['email'],
                'phone'               => $data['phone'],
                'marital_status'      => $data['marital_status'],
                'education'           => $data['education'],
                'salary'              => $data['salary'],
                'bank_account_name'   => $data['bank_account_name'],
                'bank_account_number' => $data['bank_account_number'],
            ];
            if (!empty($data['password'])) {
                $recUpdates['password'] = Hash::make($data['password']);
            }
            if (isset($data['photo'])) {
                $recUpdates['photo'] = $data['photo'];
            }
            $rec->update($recUpdates);

            DB::commit();

            return redirect()
                ->route('admin.employees.index')
                ->with('success', 'Data pegawai berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Update failed', ['error' => $e->getMessage()]);
            return back()
                ->withErrors(['error' => 'Gagal update: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function destroy(Employee $employee)
    {
        if ($employee->photo) {
            Storage::disk('public')->delete($employee->photo);
        }
        $employee->delete();

        return redirect()
            ->route('admin.employees.index')
            ->with('success', 'Pegawai berhasil dihapus.');
    }
}
