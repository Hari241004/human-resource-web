<?php

namespace App\Http\Controllers\Api\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LeaveRequest;

class LeaveRequestController extends Controller
{
    /**
     * GET /api/employee/cuti
     * List my leave requests.
     */
    public function index()
    {
        $employee = Auth::user()->employee;
        if (! $employee) {
            return response()->json(['error'=>'Not an employee'],403);
        }

        $leaves = LeaveRequest::where('employee_id',$employee->id)
                              ->orderByDesc('start_date')
                              ->paginate(10);

        return response()->json($leaves);
    }

    /**
     * POST /api/employee/cuti
     * Submit a leave request.
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
        if (! $employee) {
            return response()->json(['error'=>'Not an employee'],403);
        }

        $leave = $employee->leaveRequests()->create($data);

        return response()->json([
            'message' => 'Leave requested',
            'leave'   => $leave
        ], 201);
    }

    /**
     * GET /api/employee/cuti/{id}
     * View one leave request.
     */
    public function show($id)
    {
        $employee = Auth::user()->employee;
        if (! $employee) {
            return response()->json(['error'=>'Not an employee'],403);
        }

        $leave = LeaveRequest::where('employee_id',$employee->id)
                             ->findOrFail($id);

        return response()->json($leave);
    }
}
