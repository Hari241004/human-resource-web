<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'payroll_id',
        'component_name',
        'component_type',
        'amount',
        'effective_month',
    ];

    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }
}
