<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialRequisition extends Model
{
    use HasFactory;

    protected $table = 'materials';



    protected $fillable = [
        "voucher_no",
        "date",
        "project_id",
        "user_id",
        "purchase_type",
        "mr_reference_code",
        "reference_date",
        "remarks"
    ];

    const REQUEST_INPUTS = [
          "voucher_no",
        "date",
        "project_id",
        "user_id",
        "purchase_type",
        "mr_reference_no",
        "mr_reference_code",
        "reference_date",
        "remarks"
    ];

    public function projects(){
        return $this->belongsTo(ProjectMaster::class, 'project_id', 'project_no');
    }
    public function users(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function material_items(){
        return $this->hasMany(MaterialRequisitionItem::class,"material_id","id");
    }
}
