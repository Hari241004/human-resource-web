<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OvertimeRequest;
use Illuminate\Support\Facades\Auth;

class OvertimeRequestController extends Controller
{
    /**
     * List semua pengajuan lembur milik karyawan yang sedang login.
     */
    public function index()
    {
        $requests = OvertimeRequest::where('employee_id', Auth::id())
                       ->orderBy('created_at', 'desc')
                       ->get();

        return view('employee.pages.overtime-requests.index', compact('requests'));
    }

    /**
     * Tampilkan form pengajuan lembur baru.
     */
    public function create()
    {
        return view('employee.pages.overtime-request');
    }

    /**
     * Simpan pengajuan lembur.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'date'       => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time'   => 'required|date_format:H:i|after_or_equal:start_time',
            'reason'     => 'nullable|string',
        ]);

        OvertimeRequest::create([
            'employee_id' => Auth::id(),
            'date'        => $data['date'],
            'start_time'  => $data['start_time'],
            'end_time'    => $data['end_time'],
            'reason'      => $data['reason'] ?? null,
        ]);

        return redirect()
               ->route('employee.overtime.requests.index')
               ->with('success', 'Overtime request submitted.');
    }

    /**
     * Tampilkan detail satu pengajuan lembur.
     */
    public function show($id)
    {
        $request = OvertimeRequest::where('employee_id', Auth::id())
                    ->findOrFail($id);

        return view('employee.pages.overtime-requests.show', compact('request'));
    }
}
