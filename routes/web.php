<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

// Reset Password
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')->with('status', __($status))
        : back()->withErrors(['email' => [($status)]]);
})->middleware('guest')->name('password.update');


// Admin Controllers
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\RecruitmentController;
use App\Http\Controllers\Admin\AttendanceController        as AdminAttendanceController;
use App\Http\Controllers\Admin\AttendanceRequestController as AdminAttendanceRequestController;
use App\Http\Controllers\Admin\OvertimeRequestController    as AdminOvertimeRequestController;
use App\Http\Controllers\Admin\LeaveRequestController       as AdminLeaveRequestController;
use App\Http\Controllers\Admin\AttendanceSummaryController;
use App\Http\Controllers\Admin\TunjanganController;
use App\Http\Controllers\Admin\PotonganController;
use App\Http\Controllers\Admin\CompanyBankAccountController;
use App\Http\Controllers\Admin\EmployeeAllowanceController;
use App\Http\Controllers\Admin\EmployeeDeductionController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\PositionController;
use App\Http\Controllers\Admin\SettingOvertimesController;
use App\Http\Controllers\Admin\PayrollController            as AdminPayrollController;
use App\Http\Controllers\Admin\ShiftController;
use App\Http\Controllers\Admin\ShiftGroupController;
use App\Http\Controllers\Admin\CalendarController;

// Employee (front-end) Controllers
use App\Http\Controllers\Employee\AttendanceController         as EmployeeAttendanceController;
use App\Http\Controllers\Employee\AttendanceRequestController  as EmployeeAttendanceRequestController;
use App\Http\Controllers\Employee\OvertimeRequestController    as EmployeeOvertimeRequestController;
use App\Http\Controllers\Employee\LeaveRequestController       as EmployeeLeaveRequestController;
use App\Http\Controllers\Employee\PayslipController            as EmployeePayslipController;
use App\Http\Controllers\Employee\ProfileController            as EmployeeProfileController;

Route::get('/', fn() => redirect()->route('login'));
Route::get('/login',  [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout',[AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    // Superadmin
    Route::prefix('superadmin')->name('superadmin.')->group(function () {
        Route::get('/dashboard', fn() => view('superadmin.pages.dashboard'))->name('dashboard');
    });

    // Admin
    Route::prefix('admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/dashboard', fn() => view('admin.pages.dashboard'))->name('dashboard');

        // Recruitment
        Route::resource('recruitment', RecruitmentController::class)
             ->only(['index','create','store','show']);

        // Employees
        Route::resource('employees', EmployeeController::class)
             ->except(['create','store']);

        // Attendance & Requests
        Route::get('attendance',          [AdminAttendanceController::class,'index'])->name('attendance.index');
        Route::get('attendance-requests', [AdminAttendanceRequestController::class,'index'])->name('attendance-requests.index');
        Route::patch('attendance-requests/{id}/approve', [AdminAttendanceRequestController::class,'approve'])->name('attendance-requests.approve');
        Route::patch('attendance-requests/{id}/reject',  [AdminAttendanceRequestController::class,'reject'])->name('attendance-requests.reject');

        // Overtime Requests
        Route::resource('overtime-requests', AdminOvertimeRequestController::class);
        Route::post('overtime-requests/{id}/approve',[AdminOvertimeRequestController::class,'approve'])->name('overtime-requests.approve');
        Route::post('overtime-requests/{id}/reject', [AdminOvertimeRequestController::class,'reject'])->name('overtime-requests.reject');

        // Leave Requests
        Route::get('leave-requests', [AdminLeaveRequestController::class,'index'])->name('leave-requests.index');
        Route::patch('leave-requests/{id}/approve',[AdminLeaveRequestController::class,'approve'])->name('leave-requests.approve');
        Route::patch('leave-requests/{id}/reject', [AdminLeaveRequestController::class,'reject'])->name('leave-requests.reject');

        // Attendance Summary
        Route::get('attendance-summary', [AttendanceSummaryController::class,'index'])->name('attendance-summary.index');

        // Master allowances & deductions
        Route::resource('tunjangan', TunjanganController::class);
        Route::resource('potongan',  PotonganController::class);

        // Company Bank Accounts
        Route::resource('company-bank-accounts', CompanyBankAccountController::class)
             ->names('company-bank-accounts');

        // Employee allowances
        Route::get   ('employee-allowances',                [EmployeeAllowanceController::class,'index'])->name('employee-allowances.index');
        Route::get   ('employee-allowances/create',         [EmployeeAllowanceController::class,'create'])->name('employee-allowances.create');
        Route::post  ('employee-allowances',                [EmployeeAllowanceController::class,'store'])->name('employee-allowances.store');
        Route::get   ('employee-allowances/{id}',           [EmployeeAllowanceController::class,'show'])->name('employee-allowances.show');
        Route::get   ('employee-allowances/{employee}/edit',[EmployeeAllowanceController::class,'edit'])->name('employee-allowances.edit');
        Route::put   ('employee-allowances/{employee}',     [EmployeeAllowanceController::class,'update'])->name('employee-allowances.update');
        Route::delete('employee-allowances/{ea}',           [EmployeeAllowanceController::class,'destroy'])->name('employee-allowances.destroy');

        // Employee deductions
        Route::get   ('employee-deductions',                [EmployeeDeductionController::class,'index'])->name('employee-deductions.index');
        Route::get   ('employee-deductions/create',         [EmployeeDeductionController::class,'create'])->name('employee-deductions.create');
        Route::post  ('employee-deductions',                [EmployeeDeductionController::class,'store'])->name('employee-deductions.store');
        Route::get   ('employee-deductions/{id}',           [EmployeeDeductionController::class,'show'])->name('employee-deductions.show');
        Route::get   ('employee-deductions/{employee}/edit',[EmployeeDeductionController::class,'edit'])->name('employee-deductions.edit');
        Route::put   ('employee-deductions/{employee}',     [EmployeeDeductionController::class,'update'])->name('employee-deductions.update');
        Route::delete('employee-deductions/{ed}',           [EmployeeDeductionController::class,'destroy'])->name('employee-deductions.destroy');

        // Departments & Positions
        Route::resource('departments', DepartmentController::class);
        Route::resource('positions',   PositionController::class);

        // Overtime Settings
        Route::get('setting-overtime/edit',   [SettingOvertimesController::class,'edit'])->name('setting_overtime.edit');
        Route::put('setting-overtime/update', [SettingOvertimesController::class,'update'])->name('setting_overtime.update');

        // Payroll
        Route::get    ('payroll',               [AdminPayrollController::class,'index'])->name('payroll.index');
        Route::get    ('payroll/create',        [AdminPayrollController::class,'create'])->name('payroll.create');
        Route::post   ('payroll',               [AdminPayrollController::class,'store'])->name('payroll.store');
        Route::delete ('payroll',               [AdminPayrollController::class,'destroyAll'])->name('payroll.destroyAll');
        Route::get    ('payroll/{payroll}',     [AdminPayrollController::class,'show'])->name('payroll.show');
        Route::patch  ('payroll/{payroll}/approve',[AdminPayrollController::class,'approve'])->name('payroll.approve');

        // Shift & ShiftGroup
        Route::resource('shifts', ShiftController::class)->only(['index','store','update','destroy']);
        Route::resource('shift-groups', ShiftGroupController::class)->except(['create','show']);
        Route::get   ('shift-groups/create',                  [ShiftGroupController::class,'create'])->name('shift-groups.create');
        Route::get   ('shift-groups/{shiftGroup}',            [ShiftGroupController::class,'show'])->name('shift-groups.show');
        Route::get   ('shift-groups/{shiftGroup}/select',     [ShiftGroupController::class,'select'])->name('shift-groups.select');
        Route::post  ('shift-groups/{shiftGroup}/employees/{employee}', [ShiftGroupController::class,'attachEmployee'])->name('shift-groups.attach-employee');
        Route::delete('shift-groups/{shiftGroup}/employees/{employee}', [ShiftGroupController::class,'detach'])->name('shift-groups.detach');
        Route::post  ('shift-groups/{shiftGroup}/move-employee',[ShiftGroupController::class,'moveEmployee'])->name('shift-groups.move-employee');

        // Calendar (Admin)
        Route::get   ('calendars',         [CalendarController::class,'index'])->name('calendars.index');
        Route::get   ('calendars/events',  [CalendarController::class,'events'])->name('calendars.events');
        Route::get   ('calendars/settings',[CalendarController::class,'settings'])->name('calendars.settings');
        Route::post  ('calendars',         [CalendarController::class,'store'])->name('calendars.store');
        Route::get   ('calendars/{calendar}/edit',[CalendarController::class,'edit'])->name('calendars.edit');
        Route::put   ('calendars/{calendar}',     [CalendarController::class,'update'])->name('calendars.update');
        Route::delete('calendars/{calendar}',     [CalendarController::class,'destroy'])->name('calendars.destroy');
    });

    // Employee (front-end)
    Route::prefix('employee')->name('employee.')->group(function () {
        Route::get('/dashboard', fn() => view('employee.pages.dashboard'))->name('dashboard');
        Route::get('profile',    [EmployeeProfileController::class,'show'])->name('profile');

        // Presensi
        Route::get('presensi',            [EmployeeAttendanceController::class,'index'])->name('presensi.index');
        Route::post('presensi',           [EmployeeAttendanceController::class,'store'])->name('presensi.store');
        Route::get('presensi/requests',   [EmployeeAttendanceRequestController::class,'index'])->name('presensi.requests.index');
        Route::get('presensi/requests/create',[EmployeeAttendanceRequestController::class,'create'])->name('presensi.requests.create');
        Route::post('presensi/requests',  [EmployeeAttendanceRequestController::class,'store'])->name('presensi.requests.store');
        Route::get('presensi/requests/{id}', [EmployeeAttendanceRequestController::class,'show'])->name('presensi.requests.show');

        // Overtime Requests
        Route::get('overtime-requests',        [EmployeeOvertimeRequestController::class,'index'])->name('overtime.requests.index');
        Route::get('overtime-requests/create', [EmployeeOvertimeRequestController::class,'create'])->name('overtime.requests.create');
        Route::post('overtime-requests',       [EmployeeOvertimeRequestController::class,'store'])->name('overtime.requests.store');
        Route::get('overtime-requests/{id}',   [EmployeeOvertimeRequestController::class,'show'])->name('overtime.requests.show');

        // Leave Requests
        Route::get('cuti',         [EmployeeLeaveRequestController::class,'index'])->name('cuti.index');
        Route::get('cuti/request', [EmployeeLeaveRequestController::class,'create'])->name('cuti.request');
        Route::post('cuti/store',  [EmployeeLeaveRequestController::class,'store'])->name('cuti.store');
        Route::get('cuti/{id}',    [EmployeeLeaveRequestController::class,'show'])->name('cuti.show');

        // Payslip (setelah Admin approve)
        Route::get('payslip',             [EmployeePayslipController::class,'index'])->name('payslip.index');
        Route::get('payslip/{payroll}',   [EmployeePayslipController::class,'show'])->name('payslip.show');
        Route::get('payslip/{payroll}/pdf',[EmployeePayslipController::class,'downloadPdf'])->name('payslip.pdf');
    });
});
