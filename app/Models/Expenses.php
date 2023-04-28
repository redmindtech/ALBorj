<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class Expenses extends Model
{
    use HasFactory;

    const REQUEST_INPUTS = ['exp_code','bill_no','bill_date','employee_no','project_no','supplier_no',
                    'exp_category_no','source', 'bill_amount', 'vat','total_amount', 'attachment','description'];
                                

    protected $table ='expenses';

    protected $primaryKey='exp_no  ';

    protected $fillable = ['exp_code','bill_no','bill_date','employee_no','project_no','supplier_no',
                    'exp_category_no','source', 'bill_amount', 'vat','total_amount', 'attachment','description'];
                                
                                  

    protected static function booted()
    {
        parent::boot();
        static::creating(function ($expense) {
            $results = DB::selectOne("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'expenses'")->AUTO_INCREMENT;
            $currentYear = substr(date('Y'), -2);
            $voucher_no = str_pad($results, 3, '0', STR_PAD_LEFT);
            $expense->exp_code = 'AB' .  $currentYear.'V'. $voucher_no;
        });
    }

}
