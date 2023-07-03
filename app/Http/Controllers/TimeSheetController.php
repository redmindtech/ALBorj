<?php

namespace App\Http\Controllers;
use App\Models\EmployeeMaster;
use App\Models\SiteMaster;
use App\Models\ProjectMaster;
use App\Models\TimeSheet;
use App\Models\EmployeeAttendanceSheet;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\TimeSheetRequest;
use Illuminate\Support\Facades\DB;
use Exception;


class TimeSheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try
        {  
            if ($request->session()->has('user')) {   
            $times = DB::table('emp_timesheets')
            ->join('site_masters', 'emp_timesheets.site_no', '=', 'site_masters.site_no')
            ->join('employee_masters', 'emp_timesheets.emp_no', '=', 'employee_masters.id')
            ->select('site_masters.*', 'employee_masters.*','emp_timesheets.*')
            ->get();
            return view('timesheet.index')->with([
                'times' => $times
            ]);
        }
        else{
            return redirect("/");
        }
            
        }
        catch (Exception $e) 
        {
            info($e);
            return response()->json('Error occured in the index', 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TimeSheetRequest $request)
    {
       
        try 
        {
            $timesheet = TimeSheet::create($request->only(TimeSheet::REQUEST_INPUTS));
            $time= TimeSheet::max('id');
            
            $Count = count($request['date']);
            
            if (!empty($request['date'])) 
            {
                for ($i = 0; $i < $Count; $i++)
                {
                    // $date = date_create_from_format('d/m/Y', $request['date'][$i]);
                    // $convertedDate = date_format($date, 'Y-m-d');

                    EmployeeAttendanceSheet::create([
                        'timesheet_id'=>$time,
                        'date'=>$request['date'][$i],
                        'start_time' => $request['start_time'][$i],
                        'end_time' => $request['end_time'][$i],
                        'total_time' => $request['total_time'][$i],
                        'ot_start_time' => $request['ot_start_time'][$i],
                        'ot_end_time' => $request['ot_end_time'][$i],
                        'ot_total_time' => $request['ot_total_time'][$i],
                        'holiday' => $request['holiday_ref'][$i],
                        'leave' => $request['leave_ref'][$i],
                        'leave_type' => $request['leave_type'][$i]
                    ]);
                }
            }  
            return response()->json('Employee TimeSheet Created Successfully', 200);
        
        } 
        catch (Exception $e) 
        {
            info($e);
            return response()->json('Error occurred in the store', 400);
        }
        
    }
    
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TimeSheet  $timeSheet
     * @return \Illuminate\Http\Response
     */
    
    public function show($id)
    {
        try 
        {      
            $time = DB::table('emp_timesheets')
            ->join('site_masters', 'emp_timesheets.site_no', '=', 'site_masters.site_no')
            ->join('employee_masters', 'emp_timesheets.emp_no', '=', 'employee_masters.id')
            ->select('site_masters.site_no','site_masters.site_name','site_masters.site_manager','site_masters.site_location', 'employee_masters.*', 'emp_timesheets.*',
            DB::raw('DATE(emp_timesheets.from_date) as from_date'),
            DB::raw('DATE(emp_timesheets.to_date) as to_date'))
            ->where('emp_timesheets.id', $id)
            ->get();    
            if ($time) {
                $time = $time->toArray();

                // Convert the data to UTF-8 encoding
                array_walk_recursive($time, function (&$value) {
                    if (is_object($value)) {
                        $value = (array) $value; // Convert the stdClass object to an array
                    }

                    if (is_array($value)) {
                        array_walk_recursive($value, function (&$item) {
                            if (!mb_check_encoding($item, 'UTF-8')) {
                                // Handle invalid characters
                                $item = mb_convert_encoding($item, 'UTF-8', 'UTF-8');
                            }
                        });
                    } else {
                        if (!mb_check_encoding($value, 'UTF-8')) {
                            // Handle invalid characters
                            $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                        }
                    }
                });
            }
            
            $time_sheet = DB::table('employee_attendance_sheets')
            ->select('employee_attendance_sheets.*',
            DB::raw('DATE(employee_attendance_sheets.date) as date'))
            ->where('employee_attendance_sheets.timesheet_id', $id)
            ->get();  
        
            return response()->json([
            'time' => $time,
            'time_sheet' => $time_sheet
            ]);
   
        } 
        catch (Exception $e) 
        {
            info($e);
            return response()->json('Error occured in the show', 400);
        }
    }  


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TimeSheet  $timeSheet
     * @return \Illuminate\Http\Response
     */
    // public function update(TimeSheetRequest $request, $id)
    // {
       
//        try
//        {
                  
//         $timesheet = TimeSheet::where('id',$id)->first();
//         $timesheet->update($request->only(TimeSheet::REQUEST_INPUTS));          
//         $timesheet_delete = EmployeeAttendanceSheet::where('attendance_id',$id)->delete();
//         $Count = count($request['date']);
        
//         if (!empty($request['date'])) {
//         for ($i = 0; $i < $Count; $i++) {

//         EmployeeAttendanceSheet::update([
//         'timesheet_id'=>$id, 
//         'date' => $request['date'][$i],
//         'start_time' => $request['start_time'][$i],
//         'end_time' => $request['end_time'][$i],
//         'total_time' => $request['total_time'][$i],
//         'ot_start_time' => $request['ot_start_time'][$i],
//         'ot_end_time' => $request['ot_end_time'][$i],
//         'ot_total_time' => $request['ot_total_time'][$i],
//         'holiday' => isset($request['holiday'][$i]) ? 1 : 0,
//         'leave' => isset($request['leave'][$i]) ? 1 : 0,
//         'leave_type' => $request['leave_type'][$i]
//         ]);
//     }
// }  
//         return response()->json('TimeSheet Created Successfully', 200);
    
//     } catch (Exception $e) {
//         info($e);
//         return response()->json('Error occurred in the store', 400);
//     }

        
    // }
    public function update(TimeSheetRequest $request, $id)
    {
        info($request);
    try {
        $timesheet = TimeSheet::findOrFail($id);
        $timesheet->update($request->only(TimeSheet::REQUEST_INPUTS));
        
        $Count = count($request['date']);
        
        if (!empty($request['date'])) {
            for ($i = 0; $i < $Count; $i++) {
                $attendanceData = [
                    'timesheet_id' => $id,
                    'date' => $request['date'][$i],
                    'start_time' => $request['start_time'][$i],
                    'end_time' => $request['end_time'][$i],
                    'total_time' => $request['total_time'][$i],
                    'ot_start_time' => $request['ot_start_time'][$i],
                    'ot_end_time' => $request['ot_end_time'][$i],
                    'ot_total_time' => $request['ot_total_time'][$i],
                    'holiday' => $request['holiday_ref'][$i],
                    'leave' => $request['leave_ref'][$i],
                    'leave_type' => $request['leave_type'][$i]
                ];
                
                EmployeeAttendanceSheet::updateOrCreate(
                    ['timesheet_id' => $id, 'date' => $request['date'][$i]],
                    $attendanceData
                );
            }
        }  

        return response()->json('Employee TimeSheet Updated Successfully', 200);
    } 
    catch (Exception $e) {
        info($e);
        return response()->json('Error occurred during the update', 400);
    }
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TimeSheet  $timeSheet
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        try 
        {
            $items = TimeSheet::findOrFail($id);
            $items->delete();
            return response()->json('Employee Timesheets Deleted Successfully', 200);

        } 
        catch (Exception $e) 
        {
            info($e);
            return response()->json('Error occured in the delete', 400);
        }
    }
}
