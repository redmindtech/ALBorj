<?php

namespace App\Http\Controllers;
use App\Models\EmployeeMaster;
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
        $sponsor  =SPONSOR;
        $department = DEPARTMENT;
        $status = STATUS;
        $religion = RELIGIONS;
        $nationality = NATIONALITY;
        $location = LOCATION;
        $visa_status = VISA_STATUS;
        $pay_group =PAY_GROUP;
        $accomodation = ACCOMODATION;
        $desigination = DESIGNATION;
        $employes = EmployeeMaster::join('visa_details', 'employee_masters.id', '=', 'visa_details.employee_no')
        ->join('salary_details', 'employee_masters.id', '=', 'salary_details.employee_no')
        ->select('employee_masters.*', 'visa_details.*', 'salary_details.*')
        ->get();
    info($employes);
        return view('employeemaster.index')->with([
            'employes' => $employes,
            'category' => $category,
            'sponsor'  => $sponsor,
            'department'=> $department,
            'status' => $status,
            'religion' => $religion,
            'nationality' => $nationality,
            'location' => $location,
            'visa_status' => $visa_status,
            'pay_group' => $pay_group,
            'accomodation' => $accomodation,
            'desigination' => $desigination
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
    
        // $data1 = $request->except(['_token']);
        try {      

        EmployeeMaster::create($request->only(EmployeeMaster::REQUEST_INPUTS));
        $request['employee_no']=EmployeeMaster::max('id');
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
            $employees = EmployeeMaster::join('visa_details', 'employee_masters.id', '=', 'visa_details.employee_no')
            ->join('salary_details', 'employee_masters.id', '=', 'salary_details.employee_no')
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
           
            $employee = EmployeeMaster::findOrFail($id);
            $employee->update($request->only(EmployeeMaster::REQUEST_INPUTS));
            $employee_no=$id;
            $salary = SalaryDetails::where('employee_no', $employee_no)->firstOrFail();
            $salary->update($request->only(SalaryDetails::REQUEST_INPUTS));
            $visa = VisaDetails::where('employee_no', $employee_no)->firstOrFail();
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
            $employee_no=$id;
            $visa = VisaDetails::where('employee_no', $employee_no)->firstOrFail();
            $visa->delete();
            $salary = SalaryDetails::where('employee_no', $employee_no)->firstOrFail();
            $salary->delete();
            $employee = EmployeeMaster::findOrFail($id);
            $employee->delete();

            return response()->json('EmployeeMaster Deleted Successfully', 200);
        
    
} 
catch (Exception $e) {
    info($e);
            return response()->json('Error occured in the edit', 400);
        }
}
}