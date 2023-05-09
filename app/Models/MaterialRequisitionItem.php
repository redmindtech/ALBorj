<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialRequisitionItem extends Model
{
    use HasFactory;
    protected $table = 'material_requisition_item';



    protected $fillable = [
        'mr_no',
        'item_no',
        'stock_qty',
        'quantity'
    ];
    protected $primaryKey='mr_item_no ';
    public function materials(){
        return $this->belongsTo(MaterialRequisition::class,'mr_no','mr_id');
    }

    public function items(){
        return $this->belongsTo(ItemMaster::class, 'item_no', 'id');
    }
    protected static function booted()
    {
        parent::boot();
        static::creating(function ($mr_item) {
            
            $mr_item->deleted='0';
            
        });
    }
}
