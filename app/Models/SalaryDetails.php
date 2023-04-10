<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryDetails extends Model
{
    use HasFactory;
    protected $table ='salary_details';
    protected $fillable =
    [
         "employee_no","total_salary","hra"
    ];
}
