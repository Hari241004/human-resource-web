<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AttendanceRequest;

class AttendanceRequestController extends Controller
{
    /**
     * Daftar riwayat pengajuan presensi.
     */
    public function index()
    {
        $employee = Auth::user()->employee;
        abort_unless($employee, 403, 'Anda tidak terdaftar sebagai pegawai.');

        $requests = $employee
            ->attendanceRequests()
            ->orderByDesc('date')
            ->paginate(10);

        return view('employee.pages.attendance-requests-index', compact('requests'));
    }

    /**
     * Form pengajuan presensi.
     */
    public function create()
    {
        return view('employee.pages.attendance-request');
    }

    /**
     * Simpan pengajuan presensi baru.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'date'   => 'required|date',
            'type'   => 'required|string|in:check-in,check-out',
            'reason' => 'nullable|string|max:255',
        ]);

        $employee = Auth::user()->employee;
        abort_unless($employee, 403, 'Anda tidak terdaftar sebagai pegawai.');

        // Buat via relasi => FK employee_id valid
        $employee->attendanceRequests()->create($data);

        return redirect()
               ->route('employee.presensi.requests.index')
               ->with('success', 'Permohonan presensi berhasil dikirim.');
    }
}
