<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Tampilkan daftar department dengan total pegawai.
     */
    public function index()
    {
        $departments = Department::withCount('employees')->get();
        return view('admin.pages.department-index', compact('departments'));
    }

    /**
     * Tampilkan form edit department.
     */
    public function edit(Department $department)
    {
        return view('admin.pages.department-edit', compact('department'));
    }

    /**
     * Update nama department.
     */
    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $department->id,
        ]);

        $department->update([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('admin.departments.index')
            ->with('success', 'Department berhasil diperbarui.');
    }

    /**
     * Simpan department baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
        ]);

        Department::create([
            'name' => $request->name,
        ]);

        return back()->with('success', 'Department berhasil ditambahkan.');
    }

    /**
     * Hapus sebuah department.
     */
    public function destroy(Department $department)
    {
        if ($department->employees()->exists()) {
            return back()->withErrors(['error' => 'Tidak bisa menghapus: masih ada pegawai di department ini.']);
        }

        $department->delete();
        return back()->with('success', 'Department berhasil dihapus.');
    }
}
