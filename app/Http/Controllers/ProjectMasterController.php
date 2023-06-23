<?php

namespace App\Http\Controllers;

use App\Models\ClientMaster;
use Illuminate\Http\Request;
use App\Models\ProjectMaster;
use App\Models\SiteMaster;
use App\Models\EmployeeMaster;

use Illuminate\Support\Facades\DB;

require_once(app_path('constants.php'));

class ProjectMasterController extends Controller
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
            $project_type = PROJECT_TYPE;
            $currency = CURRENCY;
            $project_status= PROJECT_STATUS;
            $projectmasters=ProjectMaster::all();
            $projectName = $projectmasters->pluck('project_name')->map(function ($name) {
                return strtolower(str_replace(' ', '', $name));
            });
            $siteNames = SiteMaster::pluck('site_name');
            $site_name = SiteMaster::select('site_name')->get();
            $client_company=ClientMaster::pluck('company_name');
            $employee=EmployeeMaster::all();
            $employee_name=$employee->pluck('firstname');
            $projectmaster = DB::table('project_masters')
            ->join('site_masters', 'project_masters.site_no', '=', 'site_masters.site_no')
            ->join('employee_masters', 'project_masters.employee_no', '=', 'employee_masters.id')
            ->join('client_masters', 'project_masters.client_no', '=', 'client_masters.client_no')
            ->select('site_masters.*', 'employee_masters.*', 'client_masters.*', 'project_masters.*',
            DB::raw('DATE(project_masters.start_date) as start_date'),
            DB::raw('DATE(project_masters.actual_project_end_date) as actual_project_end_date'))
            ->get();
            return view('projectmaster.index')->with([
                'projectmasters' => $projectmaster,
                'project_type' => $project_type,
                'project_status'=>$project_status ,
                'projectName'=>$projectName,
                'siteNames'=>$siteNames,
                'employee_name'=>$employee_name,
                'client_company'=>$client_company,
                'currency'=>$currency,
                'site_name' => $site_name
            ]);
        }
        else{
            return redirect("/");
        }
        }
        catch (Exception $e)
        {
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
    public function store(Request $request)
    {
        if($request['amount_type']=="")
        {
            $request['amount_type']='1' ;
        }
        if($request['advanced_amount'] == "")
        {
            $request['amount_type']=null ;
        }
        //
        if($request['retention_type']=="")
        {
            $request['retention_type']='1' ;
        }
        if($request['retention'] == "")
        {
            $request['retention_type']=null ;
        }
info($request);
        try
        {

            ProjectMaster::create($request->only(ProjectMaster::REQUEST_INPUTS));
            return response()->json('Project Details Added Successfully', 200);

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
     * @param  int  $project_no
     * @return \Illuminate\Http\Response
     */
    public function show($project_no)
    {

        try
        {

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
            if ($data) {
                $data = $data->toArray();

                // Convert the data to UTF-8 encoding
                array_walk_recursive($data, function (&$value) {
                    if (is_object($value)) {
                        $value = (array) $value; // Convert the stdClass object to an array
                    }

                    if (is_array($value)) {
                        array_walk_recursive($value, function (&$item) {
                            $item = mb_convert_encoding($item, 'UTF-8', 'UTF-8');
                        });
                    } else {
                        $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                    }
                });
            }

             return response()->json($data);

        }
        catch (Exception $e)
        {
            info($e);
            return response()->json('Error occured in the show', 400);
        }
    }

    // UPDATE DATA
    public function update(Request $request, $id)
    {

        try {
            if($request['amount_type']==''){
                $request['amount_type']='0';
             }
             if($request['retention_type']==''){
                $request['retention_type']='0';
             }


            $project = ProjectMaster::findOrFail($id);
            $project->update($request->only(ProjectMaster::REQUEST_INPUTS));
            return response()->json('Project Details Updated Successfully', 200);
        } catch (Exception $e) {
            info($e);
            return response()->json('Error occurred in the update', 400);
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

        try
        {
            $site = ProjectMaster::findOrFail($project_no);
            $site->delete();
            return response()->json('Project Details Deleted Successfully', 200);

        }
        catch (Exception $e)
        {
            info($e);
            return response()->json('Error occured in the delete', 400);
        }
    }
}