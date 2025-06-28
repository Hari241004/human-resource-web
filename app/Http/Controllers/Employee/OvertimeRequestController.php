<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OvertimeRequest;
use Illuminate\Support\Facades\Auth;

class OvertimeRequestController extends Controller
{
    /**
     * Tampilkan form pengajuan lembur.
     */
    public function create()
    {
        return view('employee.pages.overtime-request');
    }

    /**
     * Simpan pengajuan lembur baru.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'date'       => 'required|date',
            'start_time' => 'required',  // validasi jam bisa dipertajam
            'end_time'   => 'required|after:start_time',
            'reason'     => 'nullable|string',
        ]);

        // Ambil Employee dari user yang login
        $employee = Auth::user()->employee;
        if (! $employee) {
            abort(403, 'Anda tidak terdaftar sebagai pegawai.');
        }

        // Buat lembur lewat relasi supaya FK pasti valid
        $employee->overtimeRequests()->create([
            'date'       => $data['date'],
            'start_time' => $data['start_time'],
            'end_time'   => $data['end_time'],
            'reason'     => $data['reason'] ?? null,
            'status'     => 'pending',     // atau default di migration
        ]);

        return redirect()
               ->route('employee.overtime.requests.index')
               ->with('success', 'Pengajuan lembur berhasil dikirim.');
    }

    /**
     * Daftar pengajuan lembur milik pegawai login.
     */
    public function index()
    {
        $employee = Auth::user()->employee;
        abort_unless($employee, 403);

        $requests = OvertimeRequest::where('employee_id', $employee->id)
            ->orderByDesc('date')
            ->paginate(10);

        return view('employee.pages.overtime-requests-index', compact('requests'));
    }

    /**
     * Tampilkan detail pengajuan lembur.
     */
    public function show($id)
    {
        $employee = Auth::user()->employee;
        abort_unless($employee, 403);

        $req = OvertimeRequest::where('employee_id', $employee->id)
                              ->findOrFail($id);

        return view('employee.pages.overtime-request-show', ['request' => $req]);
    }
}
