<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Employee;

class Recruitment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'employee_id',
        'name',
        'address',
        'place_of_birth',
        'date_of_birth',
        'kk_number',
        'religion',
        'gender',
        'department',
        'position',
        'title',
        'tmt',
        'contract_end_date',
        'salary',
        'photo',
        'email',
        'password',
        'phone',
        'marital_status',
        'education',
        'bank_account_name',
        'bank_account_number',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_of_birth'       => 'date',
        'tmt'                 => 'date',
        'contract_end_date'   => 'date',
        'salary'              => 'decimal:2',
    ];

    /**
     * Recruitment → User
     *
     * Each recruitment is created by one user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Recruitment → Employee
     *
     * Each recruitment record belongs to one employee.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
