<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class EmployeeMaster extends Model
{
    use HasFactory;
    protected $fillable =
    [
         "employee_no","firstname","lastname","fathername","mothername",
        "join_date","end_date","category","sponser","working_as","desigination","depart",
        "status","religion","nationality","city","phone","UAE_mobile_number","pay_group",
        "accomodation","passport_no","passport_expiry_date","emirates_id_no","emirates_id_from_date","emirates_id_to_date",
    ];


    public function SalaryDetails()
    {
        return $this->hasOne(SalaryDetails::class, 'sno', 'id');
    }

    public function VisaDetails()
    {
        return $this->hasOne(VisaDetails::class, 'sno', 'id');
    }
}

$result = EmployeeMaster::with([ 'SalaryDetails', 'VisaDetails'])
            ->get();
