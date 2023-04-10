<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteMaster extends Model
{
    use HasFactory;
    protected $fillable = ['site_name','site_location','site_building','site_floor','room_number','site_address','description','site_status','site_manager'];

}
