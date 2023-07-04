<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PaymentPayable extends Model
{
    use HasFactory;
    const REQUEST_INPUTS = ['ap_code','grn_no','project_no','grn_date','invoice_amount','payment_mode','opening_balance','closing_balance','cheque_no','cheque_date','deleted'];
    protected $table ='payment_payable';

    protected $fillable = ['ap_code','grn_no','project_no','grn_date','invoice_amount','payment_mode','opening_balance','closing_balance','cheque_no','cheque_date','deleted'];
    protected $primaryKey='ap_no';
    protected static function booted()
    {
        parent::boot();
        static::creating(function ($payable) {
            $results = DB::selectOne("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'payment_payable'")->AUTO_INCREMENT;
            $currentYear = substr(date('Y'), -2);
            $ap_no = str_pad($results, 2, '0', STR_PAD_LEFT);
            $payable->ap_code = 'AP' . $currentYear .'AP'. $ap_no;
            $payable->deleted='0';
      });
    }


}