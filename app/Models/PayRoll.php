<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayRoll extends Model
{
    use HasFactory;

    const REQUEST_INPUTS = [ 'employee_id','month','year','project_id','lop_days',
    'worked_days','ot_hours','basic','hra','conveyance','medical','special','ot','total_deduction','netpay','payment_mode','total_earning','amount_words'];

    protected $table ='employee_payroll';

    protected $fillable = ['employee_id','month','year','project_id','lop_days',
    'worked_days','ot_hours','basic','hra','conveyance','medical','special','ot','total_deduction','netpay','payment_mode','total_earning','amount_words'];

    protected $primaryKey='id';
    protected static function booted()
    {
        parent::boot();
        static::creating(function ($payroll) {

            $payroll->deleted='0';

        });
    }

}