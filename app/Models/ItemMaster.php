<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemMaster extends Model
{
    use HasFactory;

    protected $table ='item_masters';
    protected $fillable =
    [
         "item_name","item_category","stock_type","item_type","supplier_name",
        "supplier_code"
    ];


}
