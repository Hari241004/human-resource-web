<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payroll extends Model
{
    // Kolom–kolom yang boleh di‐mass‐assign
    protected $fillable = [
        'employee_id',
        'start_date',
        'end_date',
        'basic_salary',
        'total_allowances',
        'total_deductions',
        'overtime_amount',
        'net_salary',
        'status',
    ];

    // Cast agar start_date & end_date jadi Carbon instance
    protected $casts = [
        'start_date'      => 'date',
        'end_date'        => 'date',
        'basic_salary'    => 'decimal:2',
        'total_allowances'=> 'decimal:2',
        'total_deductions'=> 'decimal:2',
        'overtime_amount' => 'decimal:2',
        'net_salary'      => 'decimal:2',
    ];

    /**
     * Aksesori untuk periode (YYYY-MM) berbasis start_date.
     */
    public function getPeriodAttribute(): string
    {
        return $this->start_date->format('Y-m');
    }

    /**
     * Relasi ke Employee.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Relasi ke detail komponen payroll.
     */
    public function details(): HasMany
    {
        return $this->hasMany(PayrollDetail::class);
    }
}
