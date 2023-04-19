<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisaDetails extends Model
{
    use HasFactory;
    const REQUEST_INPUTS = [
        "employee_id","visa_status","expiry_date","deleted"
    ];
    protected $table ='visa_details';
    protected $primaryKey='sno';
    protected $fillable =
    [
         "employee_id","visa_status","expiry_date","deleted" 
    ];
    public function employemaster()
    {
        return $this->belongsTo(EmployeeMaster::class, 'employee_id','id');
    }
    protected static function booted()
    {
        parent::boot();
        static::creating(function ($employee) {           
            $employee->deleted='0';
        });
    }
}
