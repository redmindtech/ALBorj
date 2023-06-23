<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollDeduction extends Model
{
    use HasFactory;
    const REQUEST_INPUTS = [
        "sno","payroll_id","deduction","reason","deleted"
    ];
    protected $table ='employee_payroll_deduction';
    
    protected $primaryKey='sno';
    protected $fillable =
    [
        "sno","payroll_id","deduction","reason","deleted"
    ];
    protected static function booted()
    {
        parent::boot();
        static::creating(function ($payroll_deduction) {

            $payroll_deduction->deleted='0';

        });
    }

    public function payrolldeduction()
    {
        return $this->belongsTo(Payroll::class, 'sno','sno');
    }


}