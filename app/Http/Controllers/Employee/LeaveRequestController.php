<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveRequest;
use Illuminate\Support\Facades\Auth;

class LeaveRequestController extends Controller
{
    /**
     * Tampilkan daftar pengajuan cuti milik pegawai yang login.
     */
    public function index(Request $request)
    {
        $employee = Auth::user()->employee;
        abort_unless($employee, 403, 'Anda tidak terdaftar sebagai pegawai.');

        $leaveRequests = LeaveRequest::where('employee_id', $employee->id)
            ->orderByDesc('start_date')
            ->paginate(10);

        return view('employee.pages.leave-requests-index', compact('leaveRequests'));
    }

    /**
     * Tampilkan form pengajuan cuti.
     */
    public function create()
    {
        return view('employee.pages.leave-request');
    }

    /**
     * Simpan pengajuan cuti baru.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'type'       => 'required|string|max:50',
            'reason'     => 'nullable|string',
        ]);

        $employee = Auth::user()->employee;
        abort_unless($employee, 403, 'Anda tidak terdaftar sebagai pegawai.');

        $employee->leaveRequests()->create([
            'start_date' => $data['start_date'],
            'end_date'   => $data['end_date'],
            'type'       => $data['type'],
            'reason'     => $data['reason'] ?? null,
        ]);

        return redirect()
               ->route('employee.cuti.index')
               ->with('success', 'Pengajuan cuti berhasil dikirim.');
    }
}
