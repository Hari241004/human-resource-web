<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendances';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'employee_id',
        'date',
        'check_in_time',
        'check_out_time',
        'photo_path',
        'check_in_location',
        'status',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'date'           => 'date',
        'check_in_time'  => 'datetime:H:i',
        'check_out_time' => 'datetime:H:i',
    ];

    /**
     * Employee who owns this attendance.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
