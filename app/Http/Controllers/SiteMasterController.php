<?php

namespace App\Http\Controllers;

use App\Models\SiteMaster;
use App\Models\EmployeeMaster;
use Exception;
use App\Http\Requests\SiteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

require_once(app_path('constants.php'));
class SiteMasterController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // INDEX FUNCTION
    public function index()
    {     
        try{  
            $site_status = SITESTATUS;       
            $sitemaster = SiteMaster::all();
            return view('sitemaster.index')->with([
                'sitemasters' => $sitemaster,
            'site_status'=>$site_status
        ]);}
        catch (Exception $e) {
            info($e);
            return response()->json('Error occured in the store', 400);
        }

    }


//     }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // STORE DATA
     public function store(SiteRequest $request)
    {
        try {

            SiteMaster::create($request->only(SiteMaster::REQUEST_INPUTS));
            return response()->json('Site Master Created Successfully', 200);

        } catch (Exception $e) {
            info($e);
            return response()->json('Error occured in the store', 400);
        }
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SiteMaster  $siteMaster
     * @return \Illuminate\Http\Response
     */
    // FOR EDIT AND SHOW DATA
    public function show($site_no)
    { 
       
        try {      
           
            $site = DB::table('site_masters')
            ->join('employee_masters', 'site_masters.site_manager', '=', 'employee_masters.id')
            ->select('site_masters.*', 'employee_masters.firstname')
            ->where('site_no',$site_no)
            ->get();    
            
            return response()->json($site);

        } catch (Exception $e) {
            info($e);
            return response()->json('Error occured in the show', 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SiteMaster  $siteMaster
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SiteMaster  $siteMaster
     * @return \Illuminate\Http\Response
     */
    // UPDATE DATA
    public function update(SiteRequest $request, $site_no)
    {
        try {
            $supplier = SiteMaster::findOrFail($site_no);
            $supplier->update($request->only(SiteMaster::REQUEST_INPUTS));
            return response()->json('Site Master Updated Successfully');

        } catch (Exception $e) {
            info($e);
            return response()->json('Error occured in the update', 400);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SiteMaster  $siteMaster
     * @return \Illuminate\Http\Response
     */
    // DELETE DATA
    public function destroy($site_no)
    { 
        
        try {
            $site = SiteMaster::findOrFail($site_no);
            $site->delete();
            return response()->json('SiteMaster Deleted Successfully', 200);

        } catch (Exception $e) {
            info($e);
            return response()->json('Error occured in the delete', 400);
        }
    }
    // AUTO COMPLETE FOR SITE MANAGER
    public function  getemployeedata(){
      
        $firstname = $_GET['firstname'];
        $data = EmployeeMaster::where('firstname','LIKE',$firstname.'%')->get();
     
        return $data;
    }
}
