<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveRequest;
use Illuminate\Support\Facades\Auth;

class LeaveRequestController extends Controller
{
    public function index(Request $request)
{
    $query = LeaveRequest::with(['employee', 'reviewer'])
        ->latest('created_at');

    if ($request->has('status') && $request->status !== '') {
        $query->where('status', $request->status);
    }

    if ($request->has('date') && $request->date !== '') {
        $query->whereDate('start_date', $request->date);
    }

    $leaveRequests = $query->paginate(10);

    return view('admin.pages.leaverequest', compact('leaveRequests'));
}

    public function approve($id)
    {
        $leave = LeaveRequest::findOrFail($id);

        $leave->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
        ]);

        return back()->with('success', 'Cuti berhasil disetujui.');
    }

    public function reject($id)
    {
        $leave = LeaveRequest::findOrFail($id);

        $leave->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
        ]);

        return back()->with('success', 'Cuti berhasil ditolak.');
    }
}
