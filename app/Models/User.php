<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    const ROLE_USER = 'user';
    const ROLE_ADMIN = 'admin';
    const ROLE_SUPERADMIN = 'superadmin';

    protected $fillable = [
        'employee_id', // ← wajib untuk relasi
        'name',
        'email',
        'password',
        'role',
        'photo',       // ← opsional, tapi baik ditambahkan jika digunakan
    ];

    protected $hidden = ['password', 'remember_token'];

    public function isAdmin() {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isSuperAdmin() {
        return $this->role === self::ROLE_SUPERADMIN;
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
