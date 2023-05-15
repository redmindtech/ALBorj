<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemSupplier extends Model
{
    use HasFactory;
    const REQUEST_INPUTS = [
        "item_no","supplier_no","quantity","price_per_qty"
    ];

    protected $table ='item_supplier';
    protected $primaryKey='sno ';
    protected $fillable =
    [
        "item_no","supplier_no","quantity","price_per_qty"
    ];

}
