<?php

namespace App\Http\Controllers;
use App\Models\EmployeeMaster;
use App\Models\VisaDetails;
use App\Models\SalaryDetails;

use Illuminate\Support\Facades\DB;


use Illuminate\Http\Request;

class EmployeeMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        // $employes = EmployeeMaster::all();
        $employe = DB::table('employee_masters')
            ->join('salary_details', 'employee_masters.id', '=', 'salary_details.sno')
            ->join('visa_details', 'salary_details.sno', '=', 'visa_details.sno')
            ->select('employee_masters.*', 'salary_details.*', 'visa_details.*')
            ->get();
            // info($employe);

        return view('employeemaster.index')->with([
            'employes' => $employe
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employeemaster.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // info($request);
        $this->validate($request, [
            'id'=> '|unique:employes',
            'employee_no' => '',
            'firstname' => 'required',
            'lastname' => 'required',
            'fathername' => 'required',
            'mothername' => 'required',
            'join_date' => 'required',
            'end_date' => 'required',
            'category' => 'required',
            'sponser' => 'required',
            'working_as' => 'required',
            'desigination' => 'required',
            'depart' => 'required',
            'status' => 'required',
            'religion' => 'required',
            'nationality' => 'required',
            'city' => 'required',
            'phone' => 'required|numeric',
            'UAE_mobile_number' => 'required|numeric',
            'pay_group' => 'required',
            'accomodation' => 'required',
            'passport_no' => 'required',
            'passport_expiry_date' => '',
            'emirates_id_no' => 'required',
            'emirates_id_from_date' => 'required',
            'emirates_id_to_date' => 'required',
            'visa_status'=>'required',
            'expiry_date'=>'required',
            'total_salary'=>'required',
            'hra'=>'required',

            //'overtime_status'=>'required',



        ]);
        // $data1 = $request->except(['_token']);
        $employeemaster = $request->only(["employee_no","firstname","lastname","fathername","mothername",
        "join_date","end_date","category","sponser","working_as","desigination","depart",
        "status","religion","nationality","city","phone","UAE_mobile_number","pay_group",
        "accomodation","passport_no","passport_expiry_date","emirates_id_no","emirates_id_from_date","emirates_id_to_date"]);
        $salarydetails= $request->only(["employee_no","total_salary","hra"]);
        $visadetails=$request->only(["employee_no","visa_status","expiry_date"]);

        SalaryDetails::create($salarydetails);
        EmployeeMaster::create($employeemaster);
        VisaDetails::create($visadetails);



        return redirect()->route('employeemaster.index')->with([
            "success" => "Employee added successfully"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employe = EmployeeMaster::where('id', $id);
        return view("employeemaster.show")->with([
            "employes" => $employe
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
{


    $data1 = $request->except(['_token', '_method']);
    SalaryDetails::where('sno', $id)->update($data1);
    EmployeeMaster::where('id', $id)->update($data1);
    VisaDetails::where('sno', $id)->update($data1);

    return redirect()->route('employeemaster.index')->with([
        "success" => "Employee updated successfully"
    ]);
}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     */
    public function employee_data()
    {
        $id=$_GET['id'];
        // info($id);
        // $data = EmployeeMaster::where('id',$id)->all();
        $data['employeemaster'] = EmployeeMaster::where('id', $id)->get();
        $data['visadetails'] = VisaDetails::where('sno', $id)->get();
        $data['salarydetails'] = SalaryDetails::where('sno', $id)->get();

        //  info($data['employeemaster']);
        return $data;
   }
   public function update(Request $request, $id)
    {
        info("hi");
        try{
        $employee = EmployeeMaster::findOrFail($request['id']);
info("hello");


        $this->validate($request, [
            //  'id'=> "unique:employee_masters,id,{$employee->id}",

            'employee_no' => '',
            'firstname' => 'required',
            'lastname' => 'required',
            'fathername' => 'required',
            'mothername' => 'required',
            'join_date' => 'required',
            'end_date' => 'required',
            'category' => 'required',
            'sponser' => 'required',
            'working_as' => '',
            'desigination' => 'required',
            'depart' => 'required',
            'status' => 'required',
            'religion' => 'required',
            'nationality' => 'required',
            'city' => 'required',
            'phone' => 'required|numeric',
            'UAE_mobile_number' => 'required|numeric',
            'pay_group' => 'required',
            'accomodation' => 'required',
            'passport_no' => 'required',
            'passport_expiry_date' => '',
            'emirates_id_no' => 'required',
            'emirates_id_from_date' => 'required',
            'emirates_id_to_date' => 'required',
            'visa_status'=>'required',
            'expiry_date'=>'required',
            'total_salary'=>'required',
            'hra'=>'required',
            //'overtime_status'=>'required',
        ]);
        info("hi2");

        $employeemaster = $request->only(["employee_no","firstname","lastname","fathername","mothername",
        "join_date","end_date","category","sponser","working_as","desigination","depart",
        "status","religion","nationality","city","phone","UAE_mobile_number","pay_group",
        "accomodation","passport_no","passport_expiry_date","emirates_id_no","emirates_id_from_date","emirates_id_to_date"]);
        $salarydetails= $request->only(["employee_no","total_salary","hra"]);
        $visadetails=$request->only(["employee_no","visa_status","expiry_date"]);

        $employee->update($employeemaster);
         $employee->salaryDetails()->update($salarydetails);
         $employee->visaDetails()->update($visadetails);

    }
    catch(Exeception $e){
        info($e);
        return redirect()->route('employeemaster.index')->with([
            "error" => "error"
        ]);

    }
        return redirect()->route('employeemaster.index')->with([
            "success" => "Employee updated successfully"
        ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        EmployeeMaster::where('id', $id)->delete();
        VisaDetails::where('sno', $id)->delete();
        SalaryDetails::where('sno', $id)->delete();


        return redirect()->route("employeemaster.index")->with([
            "success" => "Employee deleted successfully"
        ]);
    }
}
