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
        static::saving(function ($client)
        {
           $results = DB::table('client_masters')->select('client_no')->get();
            info($results);
           
            if (count($results) > 0)
            {
                $client->client_code = 'AB' .'CL'. '00' . ($results[count($results) - 1]->client_no +1);
            }
            else
            {
                $client->client_code =  'AB' .'CL'. '00' .'1';
            }


        });
    }
    public function ProjectMaster()
    {
        return $this->hasMany(ProjectMaster::class, 'client_no','client_no');
    }
}