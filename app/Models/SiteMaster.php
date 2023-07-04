<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class SiteMaster extends Model
{
    use HasFactory;
    const REQUEST_INPUTS = [
        "site_name",
        "site_code",
        "site_location",
        "site_building",
        "site_floor",
        "room_number",
        "site_address",
        "description",
        "site_status",
        "site_manager",
        "deleted"
    ];
    protected $table ='site_masters';
    protected $primaryKey='site_no';

    protected $fillable = ['site_name','site_code','site_location','site_building','site_floor','room_number','site_address','description','site_status','site_manager','deleted'];

    public function EmployeeMaster() {
        return $this->belongsTo(EmployeeMaster::class,'site_manager','id');
        
    }
    protected static function booted()
    {
        parent::boot();
        static::creating(function ($site) {
            $results = DB::selectOne("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'site_masters'")->AUTO_INCREMENT;
            $currentYear = substr(date('Y'), -2);
            $siteNo = str_pad($results, 3, '0', STR_PAD_LEFT);
            $site->site_code = 'ST' .  $currentYear. $siteNo;
            $site->deleted ='0';
        });
    }
    public function ProjectMaster()
    {
        return $this->hasMany(ProjectMaster::class, 'site_no','site_no');
    }
}
