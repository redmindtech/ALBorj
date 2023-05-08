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
        'quantity'
    ];
    protected $primaryKey='mr_item_no ';
    public function materials(){
        return $this->belongsTo(MaterialRequisition::class,'material_id','id');
    }

    public function items(){
        return $this->belongsTo(ItemMaster::class, 'item_no', 'id');
    }
}
