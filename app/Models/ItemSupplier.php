<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemSupplier extends Model
{
    use HasFactory;
    const REQUEST_INPUTS = [
        "item_no","supplier_no","quantity","added_date","price_per_qty","deleted"
    ];

    protected $table ='item_supplier';
    protected $primaryKey='sno';
    protected $fillable =
    [
        "item_no","supplier_no","quantity","added_date","price_per_qty","deleted"

    ];
    public function itemmaster()
    {
        return $this->belongsTo(SupplierMaster::class, 'supplier_no','supplier_no');
    }
    protected static function booted()
    {
        parent::boot();
        static::creating(function ($itemsupplier) {
            
            $itemsupplier->deleted='0';
        });
    }
    


}