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
        "site_manager"
    ];
    protected $table ='site_masters';
    protected $primaryKey='site_no';

    protected $fillable = ['site_name','site_code','site_location','site_building','site_floor','room_number','site_address','description','site_status','site_manager'];

    public function EmployeeMaster() {
        return $this->belongsTo(EmployeeMaster::class,'site_manager','id');
        
    }
    protected static function booted()
    {
        static::saving(function ($site) {
            $results = SiteMaster::max('site_no');
            info($results);
            $currentYear = substr(date('Y'), -2);
            if ($results > 0) {
                $site->site_code = 'ST' .  $currentYear. '0' . ($results +1 );
            } else {
                $site->site_code = 'ST' .  $currentYear.'0' .'1';
            }
            


        });
    }
    public function ProjectMaster()
    {
        return $this->hasMany(ProjectMaster::class, 'site_no','site_no');
    }
}
