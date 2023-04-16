<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class SupplierMaster extends Model
{
    use HasFactory;

    const REQUEST_INPUTS = [
        "name",
        "company_name",
        "code",
        "address",
        "contact_number",
        "mail_id",
        "website"
    ];
    protected $table ='supplier_masters';
    protected $primaryKey='supplier_no';
    protected $fillable =
    [
         "name","company_name","code","address",
        "contact_number","mail_id","website"
    ];
    protected static function booted()
    {
        static::saving(function ($supplier) {
           $results = DB::table('supplier_masters')->select('supplier_no')->get();
            info($results);
            // $supplier->code = substr($supplier->company_name, 0, 3) . '00' . $results[count($results) - 1]->supplier_no;
            if (count($results) > 0) {
                $supplier->code = substr($supplier->company_name, 0, 3) . '00' . ($results[count($results) - 1]->supplier_no +1);
            } else {
                $supplier->code = substr($supplier->company_name, 0, 3) . '00' .'1';
            }


        });
    }
}