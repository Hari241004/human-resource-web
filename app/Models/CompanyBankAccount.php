<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyBankAccount extends Model
{
    protected $fillable = [
        'bank_name',
        'bank_account_number',
        'bank_account_owner',
        'is_default',
    ];
    public function payroll()
{
    return $this->hasMany(Payroll::class);
}

}
