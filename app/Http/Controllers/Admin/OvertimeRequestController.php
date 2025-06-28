<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OvertimeRequest;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OvertimeRequestController extends Controller
{
    /**
     * Tampilkan daftar pengajuan lembur dengan pagination.
     */
    public function index()
    {
        $overtimeRequests = OvertimeRequest::with('employee')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $pendingCount = OvertimeRequest::where('status', 'pending')->count();

        return view('admin.pages.overtime-requests-index', [  // pastikan view ini sesuai
            'overtimeRequests'    => $overtimeRequests,
            'pendingOvertimeRequests' => $pendingCount,
        ]);
    }

    /**
     * Form tambah pengajuan lembur.
     */
    public function create()
    {
        $employees = Employee::orderBy('name')->get();
        return view('admin.pages.overtime-requests-create', compact('employees'));
    }

    /**
     * Simpan pengajuan lembur baru.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|exists:employees,id',
            'date'        => 'required|date',
            'start_time'  => 'required|date_format:H:i',
            'end_time'    => 'required|date_format:H:i|after:start_time',
            'reason'      => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        OvertimeRequest::create([
            'employee_id' => $request->employee_id,
            'date'        => $request->date,
            'start_time'  => $request->start_time,
            'end_time'    => $request->end_time,
            'reason'      => $request->reason,
            'status'      => 'pending',
        ]);

        return redirect()
            ->route('admin.overtime-requests.index')
            ->with('success', 'Pengajuan lembur berhasil dikirim.');
    }

    /**
     * Approve pengajuan lembur.
     */
    public function approve($id)
    {
        $overtime = OvertimeRequest::findOrFail($id);
        $overtime->status = 'approved';
        $overtime->save();

        return redirect()
            ->route('admin.overtime-requests.index')
            ->with('success', 'Pengajuan lembur disetujui.');
    }

    /**
     * Reject pengajuan lembur.
     */
    public function reject($id)
    {
        $overtime = OvertimeRequest::findOrFail($id);
        $overtime->status = 'rejected';
        $overtime->save();

        return redirect()
            ->route('admin.overtime-requests.index')
            ->with('success', 'Pengajuan lembur ditolak.');
    }
}
