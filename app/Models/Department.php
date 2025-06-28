<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi massal
    protected $fillable = [
        'name',
    ];

    /**
     * Satu Department memiliki banyak Position
     */
    public function positions()
    {
        return $this->hasMany(Position::class);
    }

    /**
     * Satu Department memiliki banyak Employee
     * (menggunakan foreign key department_id pada tabel employees)
     */
    public function employees()
    {
        return $this->hasMany(Employee::class, 'department_id');
    }
}
