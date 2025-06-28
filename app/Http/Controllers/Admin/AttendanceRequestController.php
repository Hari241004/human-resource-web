<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRequest;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AttendanceRequestController extends Controller
{
    public function index(Request $request)
{
    {
    $query = AttendanceRequest::with(['employee', 'reviewer'])->orderBy('submission_time', 'desc');

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('date')) {
        $query->whereDate('date', $request->date);
    }

    $requests = $query->paginate(15);

    return view('admin.pages.attendancerequest', compact('requests'));
}
}


    public function approve($id)
    {
        $attendanceRequest = AttendanceRequest::findOrFail($id);

        $attendanceRequest->update([
            'status' => 'approved',
            'reviewed_by' => Auth::id(),
        ]);

        Attendance::create([
            'employee_id'    => $attendanceRequest->employee_id,
            'date'           => $attendanceRequest->date,
            'status'         => $attendanceRequest->type === 'late' ? 'late' : 'present',
            'check_in_time'  => null,
            'check_out_time' => null,
            'notes'          => 'Disetujui dari pengajuan presensi',
        ]);

        return back()->with('success', 'Pengajuan disetujui.');
    }

    public function reject($id)
    {
        $attendanceRequest = AttendanceRequest::findOrFail($id);

        $attendanceRequest->update([
            'status' => 'rejected',
            'reviewed_by' => Auth::id(),
        ]);

        return back()->with('success', 'Pengajuan ditolak.');
    }

    
}
