<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryDetails extends Model
{
    use HasFactory;
    const REQUEST_INPUTS = [
        "employee_no","total_salary","hra"
    ];

    protected $table ='salary_details';
    protected $primaryKey='sno';
    protected $fillable =
    [
         "employee_no","total_salary","hra"
    ];
    public function employemaster()
    {
        return $this->belongsTo(EmployeeMaster::class, 'employee_no','id');
    }
}
