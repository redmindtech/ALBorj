<?php

namespace App\Http\Controllers;
use App\Models\EmployeeMaster;
use App\Models\ProjectMaster;
use App\Models\VisaDetails;
use App\Models\SalaryDetails;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
require_once(app_path('constants.php'));

class EmployeeMasterController extends Controller
{
    // FOR LOADING PAGE
    public function index()
    {
        try
        {
            if (session()->has('user')) 
            {
                $project_name = ProjectMaster::where('deleted', 0)
                ->pluck('project_name');            
                $category = CATEGORY; 
                $sponsor  = SPONSOR;
                $sponsor1 = EmployeeMaster::where('deleted', 0)
                ->distinct()
                ->pluck('sponser')
                ->toArray();            
                $array1 = array_combine($sponsor1,$sponsor1);
                $spo = array_unique(array_merge( $sponsor,$array1));    
                $working_as = WORKING_AS;
                $working = EmployeeMaster::where('deleted', 0)
                ->distinct()
                ->pluck('working_as')
                ->toArray();
            
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
                $v_des = EmployeeMaster::where('deleted', 0)
                ->distinct()
                ->pluck('designation')
                ->toArray();
            
                $array = array_combine($v_des,$v_des);
                $merged = array_unique(array_merge( $desigination,$array));
                $employee_uae = EmployeeMaster::where('deleted', 0)
                ->pluck('UAE_mobile_number');  
                $employes = EmployeeMaster::join('visa_details', 'employee_masters.id', '=', 'visa_details.employee_id')
                            ->join('salary_details', 'employee_masters.id', '=', 'salary_details.employee_id')
                            ->select('employee_masters.*', 'visa_details.*', 'salary_details.*',
                            DB::raw('DATE(employee_masters.join_date) as join_date'))
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
                    'desigination' => $merged,
                    'employee_uae'=>$employee_uae,
                    'project_name'=>$project_name
                    
                ]);
        }
        else{
            return redirect("/");
        }
        }
        catch (Exception $e) {
            info($e);
            return response()->json('Error occured in the loading page', 400);
        }
    }
        // TO SAVE DATA
    public function store(Request $request)
    {
        if($request['over_time']=='')
        {
            $request['over_time']='0';
        }
        $file = $request->file('attachments');
        
        try
        {
            $employes=EmployeeMaster::create($request->only(EmployeeMaster::REQUEST_INPUTS));
            $request['employee_id']=EmployeeMaster::max('id');
            SalaryDetails::create($request->only(SalaryDetails::REQUEST_INPUTS));
            VisaDetails::create($request->only(VisaDetails::REQUEST_INPUTS));
            if ($file) {
                $fileData = file_get_contents($file->getRealPath());
                $fileName = $file->getClientOriginalName();
      // Save the file data as a BLOB in the database
                $employes->attachments = $fileData;
                $employes->filename = $fileName;
                $employes->save();
            }
            return response()->json('Employee Details Added Successfully', 200);

        }catch (Exception $e) {
                info($e);
                return response()->json('Error occured in the store', 400);
        }

    }

//    GET DATA FOR EDIT AND SHOW
    public function show($id)
    {
        try
        {
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
            if ($employees) {
                $employees = $employees->toArray();

                // Convert the data to UTF-8 encoding
                array_walk_recursive($employees, function (&$value) {
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

             return response()->json($employees);

        } catch (Exception $e) {
            info($e);
            return response()->json('Error occured in the show', 400);
        }
    }

//    UPDATE FUNCTION
     public function update(Request $request, $id)
     {
 
         try
         {
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
              // Check if the delete button was clicked and delete the attachments
         if ($request->has('delete_attachment') && $request->input('delete_attachment') === '1') {
             $employee->attachments = null;
             $employee->filename = null;
             $employee->save();
         }
 
         // Update the attachments if a new file is uploaded
         $file = $request->file('attachments');
         if ($file) {
             $fileData = file_get_contents($file->getRealPath());
             $fileName = $file->getClientOriginalName();
 
             $employee->attachments = $fileData;
             $employee->filename = $fileName;
             $employee->save();
         }
 
             return response()->json('Employee Details Updated Successfully');
 
 
         }catch(Exeception $e){
             info($e);
 
             return response()->json('Error occured in the update', 400);
         }
 
     }
    // DELETE FUNCTION
    public function destroy($id)
    {
        try
        {            
            $employee = EmployeeMaster::findOrFail($id);
            $employee->update(['deleted' => 1]);
            $employee_no=$id;
            $salary = SalaryDetails::where('employee_id', $employee_no)->firstOrFail();
            $salary->update(['deleted' => 1]);
            $visa = VisaDetails::where('employee_id', $employee_no)->firstOrFail();
            $visa->update(['deleted' => 1]);
            return response()->json('Employee Details Deleted Successfully', 200);       
    
        } 
        catch (Exception $e) {
            info($e);
                    return response()->json('Error occured in the edit', 400);
        }
    }

}