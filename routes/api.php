<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Auth
use App\Http\Controllers\Api\AuthController;

// Admin API Controllers
use App\Http\Controllers\Api\Admin\RecruitmentController            as ApiRecruitmentController;
use App\Http\Controllers\Api\Admin\EmployeeController               as ApiEmployeeController;
use App\Http\Controllers\Api\Admin\AttendanceController             as ApiAdminAttendanceController;
use App\Http\Controllers\Api\Admin\AttendanceRequestController      as ApiAdminAttendanceRequestController;
use App\Http\Controllers\Api\Admin\OvertimeRequestController        as ApiAdminOvertimeRequestController;
use App\Http\Controllers\Api\Admin\LeaveRequestController           as ApiAdminLeaveRequestController;
use App\Http\Controllers\Api\Admin\AttendanceSummaryController      as ApiAttendanceSummaryController;
use App\Http\Controllers\Api\Admin\TunjanganController              as ApiTunjanganController;
use App\Http\Controllers\Api\Admin\PotonganController               as ApiPotonganController;
use App\Http\Controllers\Api\Admin\CompanyBankAccountController     as ApiCompanyBankAccountController;
use App\Http\Controllers\Api\Admin\EmployeeAllowanceController      as ApiEmployeeAllowanceController;
use App\Http\Controllers\Api\Admin\EmployeeDeductionController      as ApiEmployeeDeductionController;
use App\Http\Controllers\Api\Admin\DepartmentController             as ApiDepartmentController;
use App\Http\Controllers\Api\Admin\PositionController               as ApiPositionController;
use App\Http\Controllers\Api\Admin\SettingOvertimesController       as ApiSettingOvertimesController;
use App\Http\Controllers\Api\Admin\PayrollController                as ApiPayrollController;
use App\Http\Controllers\Api\Admin\ShiftController                  as ApiShiftController;
use App\Http\Controllers\Api\Admin\ShiftGroupController             as ApiShiftGroupController;
use App\Http\Controllers\Api\Admin\CalendarController               as ApiCalendarController;

// Employee API Controllers
use App\Http\Controllers\Api\Employee\ProfileController             as ApiEmployeeProfileController;
use App\Http\Controllers\Api\Employee\AttendanceController          as ApiEmployeeAttendanceController;
use App\Http\Controllers\Api\Employee\AttendanceRequestController   as ApiEmployeeAttendanceRequestController;
use App\Http\Controllers\Api\Employee\OvertimeRequestController     as ApiEmployeeOvertimeRequestController;
use App\Http\Controllers\Api\Employee\LeaveRequestController        as ApiEmployeeLeaveRequestController;
use App\Http\Controllers\Api\Employee\PayslipController             as ApiEmployeePayslipController;

// Public routes
Route::post('login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Logout & current user
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me',      [AuthController::class, 'me']);

    // Admin routes (prefix: /api/admin)
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::apiResource('recruitment', ApiRecruitmentController::class)
             ->only(['index','store','show']);

        Route::apiResource('employees', ApiEmployeeController::class);

        // Attendances
        Route::get('attendance',              [ApiAdminAttendanceController::class,'index']);
        Route::get('attendance/{attendance}', [ApiAdminAttendanceController::class,'show']);

        // Attendance Requests
        Route::get('attendance-requests',                                      [ApiAdminAttendanceRequestController::class,'index']);
        Route::patch('attendance-requests/{attendance_request}/approve',       [ApiAdminAttendanceRequestController::class,'approve']);
        Route::patch('attendance-requests/{attendance_request}/reject',        [ApiAdminAttendanceRequestController::class,'reject']);

        // Overtime Requests
        Route::apiResource('overtime-requests', ApiAdminOvertimeRequestController::class);
        Route::post('overtime-requests/{overtime_request}/approve',           [ApiAdminOvertimeRequestController::class,'approve']);
        Route::post('overtime-requests/{overtime_request}/reject',            [ApiAdminOvertimeRequestController::class,'reject']);

        // Leave Requests
        Route::get('leave-requests',                                           [ApiAdminLeaveRequestController::class,'index']);
        Route::patch('leave-requests/{leave_request}/approve',                [ApiAdminLeaveRequestController::class,'approve']);
        Route::patch('leave-requests/{leave_request}/reject',                 [ApiAdminLeaveRequestController::class,'reject']);

        // Attendance Summary
        Route::get('attendance-summary', [ApiAttendanceSummaryController::class,'index']);

        // Master tunjangan & potongan
        Route::apiResource('tunjangan', ApiTunjanganController::class);
        Route::apiResource('potongan',  ApiPotonganController::class);

        // Company bank accounts
        Route::apiResource('company-bank-accounts', ApiCompanyBankAccountController::class);

        // Employee allowances & deductions
        Route::apiResource('employee-allowances', ApiEmployeeAllowanceController::class);
        Route::apiResource('employee-deductions', ApiEmployeeDeductionController::class);

        // Departments & positions
        Route::apiResource('departments', ApiDepartmentController::class);
        Route::apiResource('positions',   ApiPositionController::class);

        // Overtime settings
        Route::get('setting-overtime', [ApiSettingOvertimesController::class,'edit']);
        Route::put('setting-overtime', [ApiSettingOvertimesController::class,'update']);

        // Payroll
        Route::get('payroll',                     [ApiPayrollController::class,'index']);
        Route::post('payroll',                    [ApiPayrollController::class,'store']);
        Route::delete('payroll',                  [ApiPayrollController::class,'destroyAll']);
        Route::get('payroll/{payroll}',           [ApiPayrollController::class,'show']);
        Route::patch('payroll/{payroll}/approve', [ApiPayrollController::class,'approve']);

        // Shifts & shift-groups
        Route::apiResource('shifts',       ApiShiftController::class)
             ->only(['index','store','update','destroy']);
        Route::apiResource('shift-groups', ApiShiftGroupController::class);

        // Calendars
        Route::apiResource('calendars',    ApiCalendarController::class);
    });

    // Employee routes (prefix: /api/employee)
    Route::prefix('employee')->name('employee.')->group(function () {
        Route::get('profile', [ApiEmployeeProfileController::class,'show']);

        // Presensi & requests
        Route::get('presensi',                [ApiEmployeeAttendanceController::class,'index']);
        Route::post('presensi',               [ApiEmployeeAttendanceController::class,'store']);
        Route::apiResource('presensi/requests', ApiEmployeeAttendanceRequestController::class)
             ->only(['index','store','show']);

        // Overtime requests
        Route::apiResource('overtime-requests', ApiEmployeeOvertimeRequestController::class)
             ->only(['index','store','show']);

        // Leave requests
        Route::apiResource('cuti', ApiEmployeeLeaveRequestController::class)
             ->only(['index','store','show']);

        // Payslips
        Route::get('payslip',             [ApiEmployeePayslipController::class,'index']);
        Route::get('payslip/{payroll}',   [ApiEmployeePayslipController::class,'show']);
        Route::get('payslip/{payroll}/pdf',[ApiEmployeePayslipController::class,'downloadPdf']);
    });
});
