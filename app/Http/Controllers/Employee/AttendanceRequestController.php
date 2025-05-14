<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AttendanceRequest;
use Illuminate\Support\Facades\Auth;

class AttendanceRequestController extends Controller
{
    /**
     * Tampilkan form pengajuan (telat, dsb.)
     */
    public function index()
    {
        return view('employee.pages.attendance-request');
    }

    /**
     * (Opsional) -- Anda bisa pertahankan create() jika suka:
     */
    public function create()
    {
        return view('employee.pages.attendance-request');
    }

    /**
     * Simpan pengajuan
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'date'   => 'required|date',
            'type'   => 'required|string|max:50',
            'reason' => 'nullable|string',
        ]);

        AttendanceRequest::create([
            'employee_id' => Auth::id(),
            'date'        => $data['date'],
            'type'        => $data['type'],
            'reason'      => $data['reason'] ?? null,
        ]);

        return redirect()
               ->route('employee.presensi.requests.index')
               ->with('success', 'Pengajuan presensi berhasil dikirim.');
    }
}
