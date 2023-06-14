<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodsReceivedNoteItem extends Model
{
    use HasFactory;
    const REQUEST_INPUTS =
    [          
        "grn_no",
        "item_no",
        "quantity",
        "rate_per_qty",    
        
        "pending_qty",
        "receiving_qty",
        "item_amount",
        "pack_specification",
        "deleted"    
        
    ];
    protected $table ='goods_received_note_item';
    protected $primaryKey='grn_item_no';
    protected $fillable =
    [
        "grn_no",
        "item_no",
        "quantity",
        "rate_per_qty",    
       
        "item_amount",
        "pending_qty",
        "receiving_qty",
        "pack_specification",
        "deleted"
    ];
    protected static function booted()
    {
        parent::boot();
        static::creating(function ($grn) {
            
            $grn->deleted='0';
            
        });
    }
    public function items(){
        return $this->belongsTo(ItemMaster::class, 'item_no', 'id');
    }
}