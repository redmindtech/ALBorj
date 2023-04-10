<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierMaster extends Model
{
    use HasFactory;
    protected $table ='supplier_masters';
    protected $primaryKey='supplier_no';
    protected $fillable =
    [
         "name","company_name","code","address",
        "contact_number","mail_id"
    ];
}
