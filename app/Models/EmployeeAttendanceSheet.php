<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAttendanceSheet extends Model
{
    use HasFactory;
    const REQUEST_INPUTS = ['date','timesheet_id','start_time','end_time','total_time','ot_start_time','ot_end_time','ot_total_time','leave','leave_type','holiday'];             

    protected $table ='employee_attendance_sheets';
    
    protected $fillable =  ['date','timesheet_id','start_time','end_time','total_time','ot_start_time','ot_end_time','ot_total_time','leave','leave_type','holiday'];

    protected $primaryKey='attendance_id';

}