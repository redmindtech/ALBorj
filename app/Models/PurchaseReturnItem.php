<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseReturnItem extends Model
{
    use HasFactory;
    const REQUEST_INPUTS =
    [
        
        "pr_item_no",
        "pr_no",
        "item_no",
        "item_return_quantity",  
        "rate_per_qty",  
        "vat",
        "item_return_total",
        "deleted", 
        
        
    ];
    protected $table ='purchase_return_item';
    protected $primaryKey='pr_item_no';
    protected $fillable =
    [
        "pr_item_no",
        "pr_no",
        "item_no",
        "item_return_quantity",
        "rate_per_qty" , 
        "vat",  
        "item_return_total",
        "deleted", 
        
        
    ];
    protected static function booted()
    {
        parent::boot();
        static::creating(function ($pr_item) {
           
            $pr_item->deleted='0';
            
        });
    }
}
