<?php

namespace App\Http\Controllers;

use App\Models\SiteTimeSheet;
use App\Models\TimeSheet;
use App\Models\EmployeeAttendanceSheet;
use App\Models\EmployeeMaster;
use App\Models\SiteMaster;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;


class SiteTimeSheetController extends Controller
{
    public function store(Request $request)
    {
        try
        {     
            $request->validate([
                'site_no' => 'required',
                'from_date' => 'required',
                'to_date' => 'required',
                'employee' => 'required|array|min:1', // Assuming 'employee' is the input containing the array of employee numbers
            ]);
    
            $employeeArray = json_decode($request->input('employee'), true);
            $remarks = $request->input('remarks');
            $site_no = $request->input('site_no');
            $from_date = $request->input('from_date');
            $to_date = $request->input('to_date');

            if (!empty($employeeArray)) 
            {
                $count = count($employeeArray);
        
                for ($i = 0; $i < $count; $i++) 
                {
                // $emp_no = $employeeArray[$i];
                    SiteTimesheet::create
                    ([
                        'remarks' => $remarks,
                        'site_no' => $site_no,
                        'from_date' => $from_date,
                        'to_date' => $to_date,
                        'emp_no' => $employeeArray[$i],
                    ]);

                    TimeSheet::create
                    ([
                        'site_no' => $site_no,
                        'from_date' => $from_date,
                        'to_date' => $to_date,
                        'emp_no' => $employeeArray[$i],
                        'status'=>'SITE',
                    ]);

                    $time= TimeSheet::max('id');
                        
                    $Count = count($request['date']);
                            
                    if (!empty($request['date'])) 
                    {
                        for ($x = 0; $x < $Count; $x++) 
                        {
                            EmployeeAttendanceSheet::create
                            ([
                                'timesheet_id'=>$time,
                                'date'=>$request['date'][$x],
                                'start_time' => $request['start_time'][$x],
                                'end_time' => $request['end_time'][$x],
                                'total_time' => $request['total_time'][$x],
                                'ot_start_time' => $request['ot_start_time'][$x],
                                'ot_end_time' => $request['ot_end_time'][$x],
                                'ot_total_time' => $request['ot_total_time'][$x],
                                'holiday' => $request['holiday_ref'][$x],
                                'leave' => $request['leave_ref'][$x],
                                'leave_type' => $request['leave_type'][$x]
                            ]);
                        }
                    } 
                }
            }
            return response()->json('Site TimeSheet Created Successfully', 200);
        } 
        catch (Exception $e) 
        {
            info($e);
            return response()->json('Error occured in the store', 400);
        }
    }
}
