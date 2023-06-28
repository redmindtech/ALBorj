<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentReceivablesItem extends Model
{
    use HasFactory;
    const REQUEST_INPUTS = [
        "id",
        "item_no",
        "specification",
        'qty',
       "remaining_qty",
        "used_qty",
        "rate_per_qty",
        "amount",
        "deleted"
];
protected $table = 'payment_receivables_item';
protected $primaryKey = 'id';
protected $fillable =
    [
        "id",
        "item_no",
        "specification",
        'qty',
      "remaining_qty",
        "used_qty",
        "rate_per_qty",
        "amount",
        "proj_receiv_no",
        "deleted"
    ];

    public function ItemMaster() {
        return $this->belongsTo(ItemMaster::class,'id','item_no');

    }
    public function PaymentReceivables() {
        return $this->belongsTo(PaymentReceivables::class,'id','proj_receiv_no');

    }
    protected static function booted()
    {
        parent::boot();
        static::creating(function ($payment_receivables_item) {
            $payment_receivables_item->deleted = '0';
        });
    }
}
