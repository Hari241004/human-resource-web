<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recruitment extends Model
{
    use HasFactory;

    // Kembalikan primary key default (kolom `id`), buang override:
    // protected $primaryKey = 'employee_id';
    // public $incrementing = false;

    protected $fillable = [
        'user_id',         // ✏️ ditambah
        'employee_id',
        'address',
        'place_of_birth',
        'date_of_birth',
        'kk_number',
        'religion',
        'gender',
        'contract_end_date',
        'email',
        'password',
        'phone',
        'marital_status',
        'education',
        'tmt',
        'salary',
        'photo',
    ];

    /** Recruitment → User */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** Recruitment → Employee */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
