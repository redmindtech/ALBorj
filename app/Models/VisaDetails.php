<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisaDetails extends Model
{
    use HasFactory;
    const REQUEST_INPUTS = [
        "employee_no","visa_status","expiry_date"
    ];
    protected $table ='visa_details';
    protected $primaryKey='sno';
    protected $fillable =
    [
         "employee_no","visa_status","expiry_date"
    ];
    public function employemaster()
    {
        return $this->belongsTo(EmployeeMaster::class, 'employee_no','id');
    }
}
