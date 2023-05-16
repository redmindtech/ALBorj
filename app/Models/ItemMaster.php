<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemMaster extends Model
{
    use HasFactory;
    const REQUEST_INPUTS = [
        "item_name","item_category","item_subcategory","stock_type","item_type",
        "total_quantity"
    ];

    protected $table ='item_masters';
    protected $primaryKey='id';
    protected $fillable =
    [
         "item_name","item_category","item_subcategory","stock_type","item_type",
        "total_quantity"
    ];


}