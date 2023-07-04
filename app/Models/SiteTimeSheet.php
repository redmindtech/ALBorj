<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteTimeSheet extends Model
{
    use HasFactory;

    const REQUEST_INPUTS = ['emp_no','site_no','from_date','to_date','remarks','status'];             

    protected $table ='site_timesheets';
    
    protected $fillable = ['emp_no','site_no','from_date','to_date','remarks','status'];

    protected $primaryKey='id';

    protected $attributes = [ 'status' => 'SITE'];

}
