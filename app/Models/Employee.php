<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Employee extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'name',
        'nik',
        'email',
        'gender',
        'title',
        'photo',
        'phone',
        'department_id',
        'position_id',
        'bank_name',
        'bank_account_name',
        'bank_account_number',
        'salary',
        'date_of_birth',
        'tmt',
        'contract_end_date',
    ];

    /**
     * Employee belongs to a User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Employee has one Recruitment record.
     */
    public function recruitment(): HasOne
    {
        return $this->hasOne(Recruitment::class, 'employee_id');
    }

    /**
     * Employee belongs to a Department.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Employee belongs to a Position.
     */
    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    /**
     * Employee has many Attendance records.
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Employee has many Attendance Requests.
     */
    public function attendanceRequests(): HasMany
    {
        return $this->hasMany(\App\Models\AttendanceRequest::class);
    }

    /**
     * Employee has many Overtime Requests.
     */
    public function overtimeRequests(): HasMany
    {
        return $this->hasMany(OvertimeRequest::class);
    }

    /**
     * Employee has many Leave Requests.
     */
    public function leaveRequests(): HasMany
    {
        return $this->hasMany(LeaveRequest::class);
    }

    /**
     * Employee has many Payrolls.
     */
    public function payrolls(): HasMany
    {
        return $this->hasMany(Payroll::class);
    }

    /**
     * Employee has many Allowances.
     */
    public function allowances(): HasMany
    {
        return $this->hasMany(EmployeeAllowance::class);
    }

    /**
     * Employee has many Deductions.
     */
    public function deductions(): HasMany
    {
        return $this->hasMany(EmployeeDeduction::class);
    }

    /**
     * Employee belongs to many ShiftGroups.
     */
    public function shiftGroups(): BelongsToMany
    {
        return $this->belongsToMany(
            ShiftGroup::class,
            'shift_group_employee',
            'employee_id',
            'shift_group_id'
        )
        ->withTimestamps();
    }
}
