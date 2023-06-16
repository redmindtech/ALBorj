<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseReturnItem extends Model
{
    use HasFactory;
    const REQUEST_INPUTS =
    [

        "pr_item_no","pr_no","item_no","pack_specification", "quantity","receiving_qty",
        "return_qty","rate_per_qty","item_amount","deleted",


    ];
    protected $table ='purchase_return_item';
    protected $primaryKey='pr_item_no';
    protected $fillable =
    [
        "pr_item_no","pr_no","item_no","pack_specification", "quantity","receiving_qty",
        "return_qty","rate_per_qty","item_amount","deleted",


    ];
    protected static function booted()
    {
        parent::boot();
        static::creating(function ($pr_item) {

            $pr_item->deleted='0';

        });
    }
}