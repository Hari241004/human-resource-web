<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use App\Models\PayrollDetail;
use App\Models\Employee;
use App\Models\OvertimeRequest;
use App\Models\SettingOvertime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PayrollController extends Controller
{
    /**
     * Daftar semua payroll (Admin).
     */
    public function index()
    {
        $payrolls = Payroll::with(['employee','details'])
            ->latest('start_date')
            ->get();

        return view('admin.pages.payroll', compact('payrolls'));
    }

    /**
     * Form pembuatan payroll baru.
     */
    public function create()
    {
        return view('admin.pages.payroll-create');
    }

    /**
     * Simpan payroll untuk semua karyawan:
     * basic + tunjangan – potongan + lembur.
     */
    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        $start = $request->start_date;
        $end   = $request->end_date;
        $rate  = SettingOvertime::first()->rate_per_hour ?? 0;

        $employees = Employee::with(['allowances','deductions','recruitment'])->get();

        DB::transaction(function() use($employees, $start, $end, $rate) {
            foreach ($employees as $emp) {
                // skip jika sudah ada untuk periode ini
                if (Payroll::where('employee_id',$emp->id)
                           ->where('start_date',$start)
                           ->where('end_date',$end)
                           ->exists()) {
                    continue;
                }

                // basic salary: pakai employees.salary fallback recruitment.salary
                $basic = $emp->salary > 0
                         ? $emp->salary
                         : optional($emp->recruitment)->salary ?? 0;

                $totalAllowances = $emp->allowances->sum('amount');
                $totalDeductions = $emp->deductions->sum('amount');

                // hitung lembur approved dalam rentang
                $overtime = OvertimeRequest::where('employee_id',$emp->id)
                    ->where('status','approved')
                    ->whereBetween('date',[$start,$end])
                    ->get()
                    ->reduce(function($sum,$r) use($rate){
                        $hrs = Carbon::parse($r->start_time)
                                     ->floatDiffInHours($r->end_time);
                        return $sum + ($hrs * $rate);
                    }, 0);

                $net = $basic + $totalAllowances + $overtime - $totalDeductions;

                // buat record header payroll
                $pr = Payroll::create([
                    'employee_id'      => $emp->id,
                    'start_date'       => $start,
                    'end_date'         => $end,
                    'basic_salary'     => $basic,
                    'total_allowances' => $totalAllowances,
                    'total_deductions' => $totalDeductions,
                    'overtime_amount'  => $overtime,
                    'net_salary'       => $net,
                    'status'           => 'pending',
                ]);

                // detail tunjangan
                foreach ($emp->allowances as $a) {
                    PayrollDetail::create([
                        'payroll_id'     => $pr->id,
                        'component_name' => $a->tunjangan->name,
                        'amount'         => $a->amount,
                        'component_type' => 'allowance',
                    ]);
                }
                // detail potongan
                foreach ($emp->deductions as $d) {
                    PayrollDetail::create([
                        'payroll_id'     => $pr->id,
                        'component_name' => $d->potongan->name,
                        'amount'         => $d->amount,
                        'component_type' => 'deduction',
                    ]);
                }
                // detail lembur
                if ($overtime > 0) {
                    PayrollDetail::create([
                        'payroll_id'     => $pr->id,
                        'component_name' => 'Lembur',
                        'amount'         => $overtime,
                        'component_type' => 'overtime',
                    ]);
                }
            }
        });

        return redirect()
            ->route('admin.payroll.index')
            ->with('success','Payroll berhasil diproses.');
    }

    /**
     * Hapus semua data payroll + detail (Admin).
     */
    public function destroyAll()
    {
        DB::transaction(function(){
            \App\Models\PayrollDetail::query()->delete();
            Payroll::query()->delete();
        });

        return redirect()
            ->route('admin.payroll.index')
            ->with('success','Semua data payroll berhasil dihapus.');
    }

    /**
     * Detail satu payroll (Admin).
     */
    public function show(Payroll $payroll)
    {
        $payroll->load(['employee','details']);
        return view('admin.pages.payroll-show', compact('payroll'));
    }

    /**
     * Approve payroll. Setelah approve,
     * redirect ke front-end payslip index.
     */
    public function approve($id)
    {
        $p = Payroll::findOrFail($id);
        $p->status = 'approved';
        $p->save();

        // kirim karyawan ke daftar payslip-nya
        return redirect()
            ->route('employee.payslip.index')
            ->with('success','Payroll telah di-approve. Silakan cek Payslip Anda.');
    }
}
