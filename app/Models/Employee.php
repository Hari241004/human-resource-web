<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',      // ✏️ ditambah
        'name',
        'gender',
        'nik',
        'email',
        'position',
        'title',
        'photo',
    ];

    /** Employee → User (banyak karyawan milik satu user) */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** Employee → Recruitment (satu-satu) */
    public function recruitment()
    {
        return $this->hasOne(Recruitment::class, 'employee_id', 'id');
    }
}
