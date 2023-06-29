<?php

namespace App\Http\Controllers;

use App\Models\SiteMaster;
use App\Models\EmployeeMaster;
use App\Models\ProjectMaster;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

require_once(app_path('constants.php'));
class SiteMasterController extends Controller
{
       // INDEX FUNCTION
    public function index()
    {     
        try
        {   if (session()->has('user')) {
            $site = SiteMaster::where('deleted', 0)
            ->get();
            $siteNames = $site->pluck('site_name')->map(function ($name) {
                return strtolower(str_replace(' ', '', $name));
            });
            $site_location =SITELOCATION;
            $employee = EmployeeMaster::where('deleted', 0)
            ->get();        
            $employee_name=$employee->pluck('firstname');
            $site_status = SITESTATUS;    
            $sitemaster = SiteMaster::join('employee_masters', 'site_masters.site_manager', '=', 'employee_masters.id')
            ->where('site_masters.deleted', 0)
            ->select('site_masters.*', 'employee_masters.firstname', DB::raw('DATE(site_masters.created_at) as date'))
            ->get();        
            return view('sitemaster.index')->with([
            'sitemasters' => $sitemaster,
            'site_status'=>$site_status,
            'siteNames'=>$siteNames,
            'site_location'=>$site_location,
            'employee_name'=>$employee_name           
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

    // STORE DATA
    public function store(Request $request)
    {
        try 
        {   SiteMaster::create($request->only(SiteMaster::REQUEST_INPUTS));
            return response()->json('Site Details Added Successfully', 200);
        } 
        catch (Exception $e) 
        {
            info($e);
            return response()->json('Error occured in the store', 400);
        }
    }
    

   
    // FOR EDIT AND SHOW DATA
    public function show($site_no)
    { 
        try 
        {      
            $site = DB::table('site_masters')
            ->join('employee_masters', 'site_masters.site_manager', '=', 'employee_masters.id')
            ->select('site_masters.*', 'employee_masters.firstname')
            ->where('site_no',$site_no)
            ->get();    
            
            return response()->json($site);

        } 
        catch (Exception $e) 
        {
            info($e);
            return response()->json('Error occured in the show', 400);
        }
    }

    
    // UPDATE DATA
    public function update(Request $request, $site_no)
    {
        try 
        {
            $supplier = SiteMaster::findOrFail($site_no);
            $supplier->update($request->only(SiteMaster::REQUEST_INPUTS));
            return response()->json('Site Details Updated Successfully');

        } 
        catch (Exception $e) 
        {
            info($e);
            return response()->json('Error occured in the update', 400);
        }

    }

    
    // DELETE DATA
    public function destroy($site_no)
    {   
        try 
        {
            $site = SiteMaster::findOrFail($site_no);
            $project = ProjectMaster::where('site_no', $site_no)->first();
        if ($project) {
            return response()->json('Cannot delete the Site Details. It is associated with a project.', 200);
        }
            $site->update(['deleted'=>'1']);
            return response()->json('Site Details Deleted Successfully', 200);

        } 
        catch (Exception $e) 
        {
            info($e);
            return response()->json('Error occured in the delete', 400);
        }
    }
    
   
}
