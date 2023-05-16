<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    use HasFactory;
    const REQUEST_INPUTS =
    [
        "po_no",
        "item_no",
        "qty",
        "rate_per_qty",
        "discount",
        "item_amount","pending_qty"
    ];
    protected $table ='purchase_order_item';
    protected $primaryKey='po_item_no';
    protected $fillable =
    [
        'po_no','item_no','qty','rate_per_qty','discount','item_amount','pending_qty'
    ];
    public function purchaseissue()
    {
        return $this->belongsTo(PurchaseOrder::class, 'po_no','po_no');
    }
    public function items(){
        return $this->belongsTo(ItemMaster::class, 'item_no', 'po_no');
    }
}
