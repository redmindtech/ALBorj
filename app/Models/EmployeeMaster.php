<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class EmployeeMaster extends Model
{
    use HasFactory;
    const REQUEST_INPUTS = [
        "employee_no","firstname","lastname","fathername","mothername",
        "join_date","end_date","category","sponser","working_as","desigination","depart",
        "status","religion","nationality","city","phone","UAE_mobile_number","pay_group",
        "accomodation","passport_no","passport_expiry_date","emirates_id_no","emirates_id_from_date","emirates_id_to_date","deleted","over_time","country_code","wps","bank_name","account_no","attachments","filename"

    ];
    protected $table ='employee_masters';
    protected $primaryKey='id';
    protected $fillable =
    [
         "employee_no","firstname","lastname","fathername","mothername",
        "join_date","end_date","category","sponser","working_as","desigination","depart",
        "status","religion","nationality","city","phone","UAE_mobile_number","pay_group",
        "accomodation","passport_no","passport_expiry_date","emirates_id_no","emirates_id_from_date","emirates_id_to_date","deleted","over_time","country_code","wps","bank_name","account_no","attachments","filename"
    ];


    public function SalaryDetails()
    {
        return $this->hasOne(SalaryDetails::class, 'employee_no ', 'id');
    }

    public function VisaDetails()
    {
        return $this->hasmany(VisaDetails::class, 'employee_no ', 'id');
    }
    public function SiteMaster()
    {
        return $this->hasMany(SiteMaster::class, 'site_manager','id');
    }
    public function ProjectMaster()
    {
        return $this->hasMany(ProjectMaster::class, 'employee_no','id');
    }
    // 
    protected static function booted()
    {
        parent::boot();
        static::creating(function ($employee) {
            $results = DB::selectOne("SELECT AUTO_INCREMENT FROM information_schema.TABLES 
            WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'employee_masters'")->AUTO_INCREMENT;
            $currentYear = substr(date('Y'), -2);
            $employeeNo = str_pad($results, 3, '0', STR_PAD_LEFT);
            $employee->employee_no = 'AB' .  $currentYear. $employeeNo;
            $employee->deleted='0';
        });
    }
}

// $result = EmployeeMaster::with([ 'SalaryDetails', 'VisaDetails'])
//             ->get();
