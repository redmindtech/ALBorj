<?php

namespace App\Http\Controllers;

use App\Models\ClientMaster;
use Illuminate\Http\Request;
use App\Models\ProjectMaster;
use App\Models\SiteMaster;
use App\Models\EmployeeMaster;
use App\Http\Requests\ProjectMasterRequest;
use Illuminate\Support\Facades\DB;

require_once(app_path('constants.php'));

class ProjectMasterController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
    {     
        try{  
            $project_type = PROJECT_TYPE;  
             
           $project_status= PROJECT_STATUS;
            $projectmaster = DB::table('project_masters')
            ->join('site_masters', 'project_masters.site_no', '=', 'site_masters.site_no')
            ->join('employee_masters', 'project_masters.employee_no', '=', 'employee_masters.id')
            ->join('client_masters', 'project_masters.client_no', '=', 'client_masters.client_no')
            ->select('site_masters.*', 'employee_masters.*', 'client_masters.*', 'project_masters.*',
            DB::raw('DATE(project_masters.start_date) as start_date'),
            DB::raw('DATE(project_masters.end_date) as end_date'),
            DB::raw('DATE(project_masters.actual_project_end_date) as actual_project_end_date'),
            DB::raw('DATE(project_masters.amount_return_date) as amount_return_date'))
      
            ->get();
            return view('projectmaster.index')->with([
                'projectmasters' => $projectmaster,
                'project_type' => $project_type,
                'project_status'=>$project_status 
        ]);}
        catch (Exception $e) {
            info($e);
            return response()->json('Error occured in the store', 400);
        }

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectMasterRequest $request)
    {
         try {

            ProjectMaster::create($request->only(ProjectMaster::REQUEST_INPUTS));
    return response()->json('Project Master Created Successfully', 200);

} catch (Exception $e) {
    info($e);
    return response()->json('Error occured in the store', 400);
}
    }

  

    /**
     * Display the specified resource.
     *
     * @param  int  $project_no
     * @return \Illuminate\Http\Response
     */
    public function show($project_no)
    { 
       
        try {      
           
            $data = DB::table('project_masters')
            ->join('site_masters', 'project_masters.site_no', '=', 'site_masters.site_no')
            ->join('employee_masters', 'project_masters.employee_no', '=', 'employee_masters.id')
            ->join('client_masters', 'project_masters.client_no', '=', 'client_masters.client_no')
            ->select('site_masters.*', 'employee_masters.*', 'client_masters.*', 'project_masters.*',
            DB::raw('DATE(project_masters.start_date) as start_date'),
            DB::raw('DATE(project_masters.end_date) as end_date'),
            DB::raw('DATE(project_masters.actual_project_end_date) as actual_project_end_date'),
            DB::raw('DATE(project_masters.amount_return_date) as amount_return_date'))
            ->where('project_masters.project_no', $project_no)
            ->get();   
               
             return response()->json($data);

        } catch (Exception $e) {
            info($e);
            return response()->json('Error occured in the show', 400);
        }
    }





    // UPDATE DATA
    public function update(ProjectMasterRequest $request, $project_no)
    {       
        try {
            $project = ProjectMaster::findOrFail($project_no);
            $project->update($request->only(ProjectMaster::REQUEST_INPUTS));
            return response()->json('Project Master Updated Successfully');

        } catch (Exception $e) {
            info($e);
            return response()->json('Error occured in the update', 400);
        }

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $project_no
     * @return \Illuminate\Http\Response
     */
    // delete
  public function destroy($project_no)
    { 
        
        try {
            $site = ProjectMaster::findOrFail($project_no);
            $site->delete();
            return response()->json('ProjectMaster Deleted Successfully', 200);

        } catch (Exception $e) {
            info($e);
            return response()->json('Error occured in the delete', 400);
        }
    }





}
