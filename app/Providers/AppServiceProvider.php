<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\AttendanceRequest;
use App\Models\LeaveRequest;
use App\Models\OvertimeRequest;
use App\Models\Department;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('*', function ($view) {
            // Attendance Requests
            try {
                $pendingAttendanceRequests = AttendanceRequest::where('status', 'pending')->count();
            } catch (\Exception $e) {
                $pendingAttendanceRequests = 0;
            }

            // Leave Requests
            try {
                $pendingLeaveRequests = LeaveRequest::where('status', 'pending')->count();
            } catch (\Exception $e) {
                $pendingLeaveRequests = 0;
            }

            // Overtime Requests
            try {
                $pendingOvertimeRequests = OvertimeRequest::where('status', 'pending')->count();
            } catch (\Exception $e) {
                $pendingOvertimeRequests = 0;
            }

            // Departments dengan total pegawai
            try {
                $departments = Department::withCount('employees')->get();
            } catch (\Exception $e) {
                $departments = collect();
            }

            // Share ke semua view
            $view->with('pendingAttendanceRequests', $pendingAttendanceRequests)
                 ->with('pendingLeaveRequests', $pendingLeaveRequests)
                 ->with('pendingOvertimeRequests', $pendingOvertimeRequests)
                 ->with('departments', $departments);
        });
    }
}
