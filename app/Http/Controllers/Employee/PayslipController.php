<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use App\Models\Employee;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class PayslipController extends Controller
{
    public function index()
    {
        // Cari employee berdasarkan user_id
        $employee = Employee::where('user_id', Auth::id())->firstOrFail();

        $payrolls = Payroll::where('employee_id', $employee->id)
            ->where('status','approved')
            ->orderBy('start_date','desc')
            ->get();

        return view('employee.pages.payslip-index', compact('payrolls'));
    }

    public function show(Payroll $payroll)
    {
        $employee = Employee::where('user_id', Auth::id())->firstOrFail();

        // Pastikan punya hak akses
        if ($payroll->employee_id !== $employee->id || $payroll->status !== 'approved') {
            abort(403);
        }

        $payroll->load('details');
        return view('employee.pages.payslip-show', compact('payroll'));
    }

    public function downloadPdf(Payroll $payroll)
    {
        $employee = Employee::where('user_id', Auth::id())->firstOrFail();

        if ($payroll->employee_id !== $employee->id || $payroll->status !== 'approved') {
            abort(403);
        }

        $payroll->load('details','employee');

        $pdf = Pdf::loadView('employee.pages.payslip-pdf', compact('payroll'))
                  ->setPaper('a4','portrait');

        return $pdf->download("payslip-{$payroll->start_date->format('Y-m')}.pdf");
    }
}
