<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class SupplierMaster extends Model
{
    use HasFactory;
    protected $table ='supplier_masters';
    protected $primaryKey='supplier_no';
    protected $fillable =
    [
         "name","company_name","code","address",
        "contact_number","mail_id","website"
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($supplier) {

            $supplier->code = Str::substr($supplier->name, 0, 3) . '00' .$supplier->supplier_no;

        });

    }
}