<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Calendar extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'description',
        'type',
        'color',
    ];

    protected $casts = [
        'date' => 'date',
    ];
}
