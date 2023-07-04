<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSheet extends Model
{
    use HasFactory;

    

    const REQUEST_INPUTS = ['emp_no','site_no','project_no','shift','task','from_date','to_date','status','deleted'];             

    protected $table ='emp_timesheets';
    
    protected $fillable = ['emp_no','site_no','project_no','shift','task','from_date','to_date','status','deleted'];

    protected $primaryKey='id';

    protected $attributes = [ 'status' => 'EMP'];

    protected static function booted()
    {
        parent::boot();
        static::creating(function ($emptimesheet) {
            
            $emptimesheet->deleted='0';
        });
    }

}
