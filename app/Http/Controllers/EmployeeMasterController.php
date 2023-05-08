<?php

namespace App\Http\Controllers;
use App\Models\EmployeeMaster;
use App\Models\ProjectMaster;
use App\Models\VisaDetails;
use App\Models\SalaryDetails;
use App\Http\Requests\EmployeeMasterRequest;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
require_once(app_path('constants.php'));

class EmployeeMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $category = CATEGORY; 
            $sponsor  = SPONSOR;
            $sponsor1 = EmployeeMaster::distinct()->pluck('sponser')->toArray();
            $array1 = array_combine($sponsor1,$sponsor1);
            $spo = array_unique(array_merge( $sponsor,$array1));
    
            $working_as = WORKING_AS;
            $working = EmployeeMaster::distinct()->pluck('working_as')->toArray();
            $array2 = array_combine($working,$working);
            $work = array_unique(array_merge($working_as,$array2));
            $department = DEPARTMENT;
            $status = STATUS;
            $religion = RELIGIONS;
            $nationality = NATIONALITY;
            $location = LOCATION;
            $visa_status = VISA_STATUS;
            $pay_group =PAY_GROUP;
            $accomodation = ACCOMODATION;
            $desigination= DESIGNATION;
            $v_des = EmployeeMaster::distinct()->pluck('desigination')->toArray();
            $array = array_combine($v_des,$v_des);
            $merged = array_unique(array_merge( $desigination,$array));
        $employes = EmployeeMaster::join('visa_details', 'employee_masters.id', '=', 'visa_details.employee_id')
        ->join('salary_details', 'employee_masters.id', '=', 'salary_details.employee_id')
        ->select('employee_masters.*', 'visa_details.*', 'salary_details.*',
        DB::raw('DATE(employee_masters.join_date) as join_date'),
        DB::raw('DATE(employee_masters.end_date) as end_date'),
        DB::raw('DATE(employee_masters.passport_expiry_date) as passport_expiry_date'),
        DB::raw('DATE(employee_masters.emirates_id_from_date) as emirates_id_from_date'),
        DB::raw('DATE(employee_masters.	emirates_id_to_date) as emirates_id_to_date'))
        ->where('employee_masters.deleted','0')
        ->get();
     
        return view('employeemaster.index')->with([
            'employes' => $employes,
            'category' => $category,
            'sponsor'  => $spo,
            'working_as'=> $work,
            'department'=> $department,
            'status' => $status,
            'religion' => $religion,
            'nationality' => $nationality,
            'location' => $location,
            'visa_status' => $visa_status,
            'pay_group' => $pay_group,
            'accomodation' => $accomodation,
            'desigination' => $merged
        ]);
    }
    catch (Exception $e) {
        info($e);
        return response()->json('Error occured in the loading page', 400);
    }
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeMasterRequest $request)
    {
     
     if($request['over_time']==''){
        $request['over_time']='0';
     }
        // $data1 = $request->except(['_token']);
        try {      

        EmployeeMaster::create($request->only(EmployeeMaster::REQUEST_INPUTS));
        $request['employee_id']=EmployeeMaster::max('id');
        SalaryDetails::create($request->only(SalaryDetails::REQUEST_INPUTS));
        VisaDetails::create($request->only(VisaDetails::REQUEST_INPUTS));        

        return response()->json('Employee Master Created Successfully', 200);      

    } catch (Exception $e) {
            info($e);
            return response()->json('Error occured in the store', 400);
        }
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $employees = EmployeeMaster::join('visa_details', 'employee_masters.id', '=', 'visa_details.employee_id')
            ->join('salary_details', 'employee_masters.id', '=', 'salary_details.employee_id')
            ->select('employee_masters.*', 'visa_details.*', 'salary_details.*',
            DB::raw('DATE(employee_masters.join_date) as join_date'),
            DB::raw('DATE(employee_masters.end_date) as end_date'),
            DB::raw('DATE(employee_masters.passport_expiry_date) as passport_expiry_date'),
            DB::raw('DATE(employee_masters.emirates_id_from_date) as emirates_id_from_date'),
            DB::raw('DATE(employee_masters.	emirates_id_to_date) as emirates_id_to_date'))
            ->where('employee_masters.id', $id)
            ->get();
            // info($employees);
             return response()->json($employees);

        } catch (Exception $e) {
            info($e);
            return response()->json('Error occured in the show', 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
 

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     */
   
   public function update(EmployeeMasterRequest $request, $id)
    {
    
        try{
            if($request['over_time']==''){
                $request['over_time']='0';
             }
           $request['deleted']='0';
            $employee = EmployeeMaster::findOrFail($id);
            $employee->update($request->only(EmployeeMaster::REQUEST_INPUTS));
            $employee_no=$id;
            $salary = SalaryDetails::where('employee_id', $employee_no)->firstOrFail();
            $salary->update($request->only(SalaryDetails::REQUEST_INPUTS));
            $visa = VisaDetails::where('employee_id', $employee_no)->firstOrFail();
            $visa->update($request->only(VisaDetails::REQUEST_INPUTS));

            return response()->json('Employee Updated Successfully');

        
    } 
    catch(Exeception $e){
        info($e);

        return response()->json('Error occured in the update', 400);
    }
        
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {          
          
            $employee = EmployeeMaster::findOrFail($id);
            $employee->update(['deleted' => 1]);
            $employee_no=$id;
            $salary = SalaryDetails::where('employee_id', $employee_no)->firstOrFail();
            $salary->update(['deleted' => 1]);
            $visa = VisaDetails::where('employee_id', $employee_no)->firstOrFail();
            $visa->update(['deleted' => 1]);
            return response()->json('EmployeeMaster Deleted Successfully', 200);       
    
        } 
        catch (Exception $e) {
            info($e);
                    return response()->json('Error occured in the edit', 400);
                }
        }

}