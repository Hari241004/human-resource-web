<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveRequest;
use Illuminate\Support\Facades\Auth;

class LeaveRequestController extends Controller
{
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

        LeaveRequest::create([
            'employee_id' => Auth::id(),
            'start_date'  => $data['start_date'],
            'end_date'    => $data['end_date'],
            'type'        => $data['type'],
            'reason'      => $data['reason'] ?? null,
        ]);

        return redirect()
               ->route('employee.cuti.request')
               ->with('success', 'Leave request submitted.');
    }
}
