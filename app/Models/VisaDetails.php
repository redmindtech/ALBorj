<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisaDetails extends Model
{
    use HasFactory;
    protected $table ='visa_details';
    protected $fillable =
    [
         "employee_no","visa_status","expiry_date"
    ];
}
