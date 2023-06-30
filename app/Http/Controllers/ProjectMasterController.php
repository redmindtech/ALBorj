<?php

namespace App\Http\Controllers;

use App\Models\ClientMaster;
use App\Models\ProjectMasterItem;
use Illuminate\Http\Request;
use App\Models\ProjectMaster;
use App\Models\SiteMaster;
use App\Models\EmployeeMaster;
use Exception;
use Illuminate\Support\Facades\DB;

require_once(app_path('constants.php'));

class ProjectMasterController extends Controller
{
    // loading page
    public function index()
    {
        try
        {
            if (session()->has('user')) {
            $project_type = PROJECT_TYPE;
            $currency = CURRENCY;
            $project_status= PROJECT_STATUS;
            $projectmasters = ProjectMaster::where('deleted', 0)->get();
            $projectName = $projectmasters->pluck('project_name')->map(function ($name) {
                return strtolower(str_replace(' ', '', $name));
            });
            $siteNames = SiteMaster::where('deleted', 0)->pluck('site_name');
            $site_name = SiteMaster::where('deleted', 0)->select('site_name')->get();
            $client_company = ClientMaster::where('deleted', 0)->pluck('company_name');
            $employee = EmployeeMaster::where('deleted', 0)->get();
            $employee_name = $employee->pluck('firstname');
            $projectmaster = DB::table('project_masters')
            ->join('site_masters', 'project_masters.site_no', '=', 'site_masters.site_no')
            ->join('employee_masters', 'project_masters.employee_no', '=', 'employee_masters.id')
            ->join('client_masters', 'project_masters.client_no', '=', 'client_masters.client_no')
            ->where('project_masters.deleted', 0)
            ->select('site_masters.*', 'employee_masters.*', 'client_masters.*', 'project_masters.*',
            DB::raw('DATE(project_masters.start_date) as start_date'),
            DB::raw('DATE(project_masters.actual_project_end_date) as actual_project_end_date'),
            DB::raw('DATE(project_masters.created_at) as date'))
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
    // data save function
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
            $request['retention_type']='1' ;
        }

        try
        {

            ProjectMaster::create($request->only(ProjectMaster::REQUEST_INPUTS));
            // ProjectMasterItem
            $project_id=ProjectMaster::max('project_no');
           
            for ($i = 0; $i < count($request['item_no']); $i++) {

                ProjectMasterItem::create([
                   'proj_no' =>$project_id,
                    'item_no' => $request['item_no'][$i],
                    'specification'=>$request['specification'][$i],
                    'qty' => $request['qty'][$i],
                    'pending_qty'=>$request['qty'][$i],
                    'unit' => $request['unit'][$i],
                    'rate_per_qty' => $request['rate_per_qty'][$i],                 
                    'amount' => $request['amount'][$i],
                  
                ]);
            }
             return response()->json('Project Details Added Successfully', 200);

        }
        catch (Exception $e)
        {
            info($e);
            return response()->json('Error occured in the store', 400);
        }
    }
    // show data for edit and show
    public function show($project_no)
    {
        try
        {   $data = DB::table('project_masters')
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
            $project_item_details=ProjectMasterItem::
            join('item_masters', 'project_master_item.item_no', '=', 'item_masters.id')  
            ->select('item_masters.*','project_master_item.*')   
            ->where('project_master_item.proj_no', $project_no)
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
            return response()->json([
                'data' => $data,
                'project_item_details' => $project_item_details
            ]);
            //  return response()->json($data);

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

            $po_delete=ProjectMasterItem::where('proj_no',$id)->delete();
            for ($i = 0;$i <  count($request['item_no']); $i++) {
              
                ProjectMasterItem::create([
                    'proj_no' =>$id,
                     'item_no' => $request['item_no'][$i],
                     'specification'=>$request['specification'][$i],
                     'qty' => $request['qty'][$i],
                     'pending_qty'=>$request['qty'][$i],
                     'unit' => $request['unit'][$i],
                     'rate_per_qty' => $request['rate_per_qty'][$i],                 
                     'amount' => $request['amount'][$i],
                   
                 ]);}
            return response()->json('Project Details Updated Successfully', 200);
        } catch (Exception $e) {
            info($e);
            return response()->json('Error occurred in the update', 400);
        }
    }
  
    // delete
    public function destroy($project_no)
    {

        try
        {
            $project = ProjectMaster::findOrFail($project_no);
            ProjectMasterItem::where('proj_no',$project_no)->update(['deleted'=>'1']);            ;
            $project->update(['deleted'=>'1']);
    
            return response()->json('Project Details Deleted Successfully', 200);

        }
        catch (Exception $e)
        {
            info($e);
            return response()->json('Error occured in the delete', 400);
        }
    }
}