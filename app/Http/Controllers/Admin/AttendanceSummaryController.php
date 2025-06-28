<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Employee;
use App\Models\OvertimeRequest;
use Carbon\Carbon;

class AttendanceSummaryController extends Controller
{
    public function index(Request $request)
    {
        // 1) Period from query or default
        $month = $request->input('month', now()->format('m'));
        $year  = $request->input('year',  now()->format('Y'));

        // 2) Eager-load attendances & leaveRequests for that month
        $employees = Employee::with([
            'attendances' => fn($q) =>
                $q->whereMonth('date', $month)
                  ->whereYear('date',  $year),
            'leaveRequests' => fn($q) =>
                $q->whereMonth('start_date', $month)
                  ->whereYear('start_date',  $year)
        ])->get();

        // 3) Build raw summary array
        $raw = $employees->map(fn($emp) => [
            'employee_name'  => $emp->name,
            'present'        => $emp->attendances->where('status','present')->count(),
            'late'           => $emp->attendances->where('status','late')->count(),
            'absent'         => $emp->attendances->where('status','absent')->count(),
            'cuti'           => $emp->leaveRequests->where('status','approved')->count(),
            'overtime_hours' => OvertimeRequest::where('employee_id',$emp->id)
                ->where('status','approved')
                ->whereMonth('date',$month)
                ->whereYear('date',$year)
                ->get()
                ->sum(fn($ot) => Carbon::parse($ot->end_time)
                                 ->diffInHours(Carbon::parse($ot->start_time))),
        ]);

        // 4) Optional search by name
        if ($search = trim($request->input('search'))) {
            $raw = $raw->filter(fn($item) =>
                str_contains(strtolower($item['employee_name']), strtolower($search))
            );
        }

        // 5) Paginate the collection
        $perPage = 9;
        $page    = $request->input('page', 1);
        $slice   = $raw->slice(($page - 1) * $perPage, $perPage)->values();
        $summary = new LengthAwarePaginator(
            $slice,
            $raw->count(),
            $perPage,
            $page,
            [
                'path'  => $request->url(),
                'query' => $request->query(),
            ]
        );

        // 6) Pass to view
        return view('admin.pages.attendance-summary', [
            'summary' => $summary,
            'month'   => $month,
            'year'    => $year,
            'search'  => $search,
        ]);
    }
}
