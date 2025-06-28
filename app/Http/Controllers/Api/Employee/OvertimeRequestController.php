<?php

namespace App\Http\Controllers\Api\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OvertimeRequest;

class OvertimeRequestController extends Controller
{
    /**
     * GET /api/employee/overtime-requests
     * List my overtime requests.
     */
    public function index()
    {
        $employee = Auth::user()->employee;
        if (! $employee) {
            return response()->json(['error'=>'Not an employee'],403);
        }

        $ots = OvertimeRequest::where('employee_id',$employee->id)
                              ->orderByDesc('date')
                              ->paginate(10);

        return response()->json($ots);
    }

    /**
     * POST /api/employee/overtime-requests
     * Submit a new overtime request.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'date'       => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time'   => 'required|date_format:H:i|after:start_time',
            'reason'     => 'nullable|string',
        ]);

        $employee = Auth::user()->employee;
        if (! $employee) {
            return response()->json(['error'=>'Not an employee'],403);
        }

        $ot = $employee->overtimeRequests()->create(array_merge($data, [
            'status' => 'pending',
        ]));

        return response()->json([
            'message'         => 'Overtime requested',
            'overtimeRequest' => $ot
        ], 201);
    }

    /**
     * GET /api/employee/overtime-requests/{id}
     * View one overtime request.
     */
    public function show($id)
    {
        $employee = Auth::user()->employee;
        if (! $employee) {
            return response()->json(['error'=>'Not an employee'],403);
        }

        $ot = OvertimeRequest::where('employee_id',$employee->id)
                             ->findOrFail($id);

        return response()->json($ot);
    }
}
