<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ClientMaster extends Model
{
    use HasFactory;

    const REQUEST_INPUTS =
    [
        "name",
        "client_code",
        "company_name",
        "contact_number",
        "address",
        "website"
    ];
    protected $table ='client_masters';
    protected $primaryKey='client_no';
    protected $fillable =
    [
        "name","client_code","company_name","contact_number","address","website"
    ];

    protected static function booted()
    {
        parent::boot();

        static::creating(function ($client)
        {
            $results = DB::selectOne("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'client_masters'")->AUTO_INCREMENT;
            $clientNo = str_pad($results, 2, '0', STR_PAD_LEFT);
            $client->client_code = 'AB'.'CL' . $clientNo;
        });
    }
    public function ProjectMaster()
    {
        return $this->hasMany(ProjectMaster::class, 'client_no','client_no');
    }
}