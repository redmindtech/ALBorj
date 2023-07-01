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
            $sitetimes = DB::table('site_timesheets')
            ->join('site_masters', 'site_timesheets.site_no', '=', 'site_masters.site_no')
            ->join('employee_masters', 'site_masters.site_manager', '=', 'employee_masters.id')
            ->select('site_masters.*', 'employee_masters.firstname AS site_manager', 'site_timesheets.*')
            ->selectRaw('DATE(site_timesheets.from_date) AS from_date')
            ->selectRaw('DATE(site_timesheets.to_date) AS to_date')
            ->get();
            return view('sitetimesheet.index')->with([
                'sitetimes' => $sitetimes
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        info($request);
        try
        {
            
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
                // Access each employee value
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
                        // 'remarks' => $remarks,
                        'site_no' => $site_no,
                        'from_date' => $from_date,
                        'to_date' => $to_date,
                        'emp_no' => $employeeArray[$i],
                    ]);
                    $time= TimeSheet::max('id');
                        
                    $Count = count($request['date']);
                            
                    if (!empty($request['date'])) 
                    {
                        for ($x = 0; $x < $Count; $x++) 
                        {
                            EmployeeAttendanceSheet::create([
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SiteTimeSheet  $siteTimeSheet
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try 
        {  
            $time = DB::table('site_timesheets')
            ->join('site_masters', 'site_timesheets.site_no', '=', 'site_masters.site_no')
            ->join('employee_masters', 'site_masters.site_manager', '=', 'employee_masters.id')
            ->select('site_masters.*', 'employee_masters.firstname AS site_manager', 'site_timesheets.*')
            ->selectRaw('DATE(site_timesheets.from_date) AS from_date')
            ->selectRaw('DATE(site_timesheets.to_date) AS to_date')
            ->where('site_timesheets.id', $id)
            ->get();
            
            $time_sheet = DB::table('employee_attendance_sheets')
            ->select('employee_attendance_sheets.*',
            DB::raw('DATE(employee_attendance_sheets.date) as date'))
            ->where('employee_attendance_sheets.timesheet_id', $id)
            ->get();  
            info($time_sheet);
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SiteTimeSheet  $siteTimeSheet
     * @return \Illuminate\Http\Response
     */
    public function edit(SiteTimeSheet $siteTimeSheet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SiteTimeSheet  $siteTimeSheet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
{
    try {
        $timesheet = SiteTimesheet::findOrFail($id);

        $employeeArray = json_decode($request->input('employee'), true);
        $remarks = $request->input('remarks');
        $site_no = $request->input('site_no');
        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');

        $timesheet->remarks = $remarks;
        $timesheet->site_no = $site_no;
        $timesheet->from_date = $from_date;
        $timesheet->to_date = $to_date;
        // Update any other fields as needed
        $timesheet->save();

        // Update the attendance sheets
        $count = count($employeeArray);
        for ($i = 0; $i < $count; $i++) {
            $attendanceData = [
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

            SiteAttendanceSheet::updateOrCreate(
                ['date' => $request['date'][$i]],
                $attendanceData
            );
        }

        return response()->json('Site TimeSheet Updated Successfully', 200);
    } catch (Exception $e) {
        info($e);
        return response()->json('Error occurred in the update', 400);
    }
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SiteTimeSheet  $siteTimeSheet
     * @return \Illuminate\Http\Response
     */
    public function destroy(SiteTimeSheet $siteTimeSheet)
    {
        
    }
}
