<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MaterialRequisition extends Model
{
    use HasFactory;

    protected $table = 'materials';



    protected $fillable = [
        "voucher_no",
        "date",
        "project_id",
        "user_id",
        //"purchase_type",
        "mr_reference_code",
        "reference_date",
        "remarks",
        "deleted"
    ];

    const REQUEST_INPUTS = [
        "voucher_no",
        "date",
        "project_id",
        "user_id",
        //"purchase_type",        
        "mr_reference_code",
        "reference_date",
        "remarks",
        "deleted"
    ];
    protected $primaryKey='mr_id';
    public function projects(){
        return $this->belongsTo(ProjectMaster::class, 'project_id', 'project_no');
    }
    public function users(){
        return $this->belongsTo(User::class, 'user_id', 'mr_id');
    }

    public function material_items(){
        return $this->hasMany(MaterialRequisitionItem::class,"material_id","id");
    }
    protected static function booted()
    {
        parent::boot();
        static::creating(function ($mr)
        {
            $results = DB::selectOne("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'materials'")->AUTO_INCREMENT;
            $currentYear = substr(date('Y'), -2);
            $MRCode = str_pad($results, 3,'0',STR_PAD_LEFT);
            $mr->mr_reference_code = 'AB'. $currentYear .'MR' . $MRCode ;
            $mr->deleted='0';
        });
    }
}