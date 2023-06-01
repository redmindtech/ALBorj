<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryDetails extends Model
{
    use HasFactory;
    const REQUEST_INPUTS = [
        "employee_id","total_salary","hra","basic","deleted"
    ];

    protected $table ='salary_details';
    protected $primaryKey='sno';
    protected $fillable =
    [
         "employee_id","total_salary","hra","basic","deleted"
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
