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
        parent::boot();
        static::creating(function ($supplier) {
            $results = DB::selectOne("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'supplier_masters'")->AUTO_INCREMENT;
            $supplierCode = substr($supplier->name, 0, 3) . '00' . $results;
            $supplier->code = $supplierCode;
        });
    }
}