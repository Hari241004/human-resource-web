<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\RecruitmentController;

// Employee routes
use App\Http\Controllers\Employee\AttendanceController;
use App\Http\Controllers\Employee\AttendanceRequestController;
use App\Http\Controllers\Employee\OvertimeRequestController;
use App\Http\Controllers\Employee\LeaveRequestController;  // ← import LeaveRequestController
use App\Http\Controllers\Employee\PayrollController;

Route::middleware(['web'])->group(function () {

    // Halaman utama → form login
    Route::get('/', fn() => view('auth.login'))->name('home');

    // Login & Logout
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/authenticating', [AuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Semua route berikut memerlukan autentikasi
    Route::middleware('auth')->group(function () {

        // Superadmin
        Route::prefix('superadmin')->name('superadmin.')->group(function () {
            Route::get('/dashboard', fn() => view('superadmin.pages.dashboard'))
                 ->name('dashboard');
        });

        // Admin
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('/dashboard', fn() => view('admin.pages.dashboard'))->name('dashboard');

            // Recruitment
            Route::get('recruitment/create', [RecruitmentController::class, 'create'])
                 ->name('recruitment.create');
            Route::post('recruitment', [RecruitmentController::class, 'store'])
                 ->name('recruitment.store');

            // Employees resource
            Route::resource('employees', EmployeeController::class)
                 ->except(['create', 'store']);
        });

        // Employee (front-end user)
        Route::prefix('employee')->name('employee.')->group(function () {
            // Dashboard
            Route::get('/dashboard', fn() => view('employee.pages.dashboard'))
                 ->name('dashboard');

            /**
             * Actual Attendance (Presensi)
             */
            Route::get('presensi', [AttendanceController::class, 'index'])
                 ->name('presensi.index');
            Route::get('presensi/request', [AttendanceController::class, 'create'])
                 ->name('presensi.request');
            Route::post('presensi/store', [AttendanceController::class, 'store'])
                 ->name('presensi.store');

            /**
             * Attendance Requests (Pengajuan Presensi)
             */
            Route::get('presensi/requests', [AttendanceRequestController::class, 'index'])
                 ->name('presensi.requests.index');
            Route::get('presensi/requests/create', [AttendanceRequestController::class, 'create'])
                 ->name('presensi.requests.create');
            Route::post('presensi/requests', [AttendanceRequestController::class, 'store'])
                 ->name('presensi.requests.store');
            Route::get('presensi/requests/{id}', [AttendanceRequestController::class, 'show'])
                 ->name('presensi.requests.show');

            /**
             * Overtime Requests (Pengajuan Lembur)
             */
            Route::get('overtime-requests', [OvertimeRequestController::class, 'index'])
                 ->name('overtime.requests.index');
            Route::get('overtime-requests/create', [OvertimeRequestController::class, 'create'])
                 ->name('overtime.requests.create');
            Route::post('overtime-requests', [OvertimeRequestController::class, 'store'])
                 ->name('overtime.requests.store');
            Route::get('overtime-requests/{id}', [OvertimeRequestController::class, 'show'])
                 ->name('overtime.requests.show');

            /**
             * Leave Requests (Pengajuan Cuti)
             */
            Route::get('cuti', [LeaveRequestController::class, 'index'])
                 ->name('cuti.index');
            Route::get('cuti/request', [LeaveRequestController::class, 'create'])
                 ->name('cuti.request');
            Route::post('cuti/store', [LeaveRequestController::class, 'store'])
                 ->name('cuti.store');
            Route::get('cuti/{id}', [LeaveRequestController::class, 'show'])
                 ->name('cuti.show');

            /**
             * Payroll (Penggajian)
             */
            Route::get('payroll', [PayrollController::class, 'index'])
                 ->name('payroll');
        });

    });

});
