<?php

namespace App\Http\Controllers;

use App\Models\SiteMaster;
use App\Models\EmployeeMaster;
use App\Http\Requests\SiteMasterRequest;
use Illuminate\Http\Request;

class SiteMasterController extends Controller
{
    public function sitegetData() {
        info('get');
        $firstname = $_GET['firstname'];
        $data = EmployeeMaster::where('firstname','LIKE',$firstname.'%')->get('firstname');
        info('hi controller');
        info($data);
        // return response()->json($data);
        return $data;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employes = EmployeeMaster::select('id')->get();
        // info($employes);
        $datas = SiteMaster::all();
        return view('sitemaster.index')->with([
            'datas' => $datas
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('sitemaster.create');

    }
public function data_edit()
    {
        $id=$_GET['id'];
        info($id);
        $data = SiteMaster::where('site_no',$id)->get();
        info($data);
        return $data;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [

            'site_name' => 'required',
            'site_location' => 'required',
            'site_building' => 'required',
            'site_floor' => 'required',
            'room_number' => 'required',
            'site_address' => 'required',
            'site_manager' => 'required'
        ]);
        $input = $request->except(['_token']);
        SiteMaster::create($input);
        return redirect()->route("sitemaster.index")->with([
            "success" => "SiteMaster added successfully"
        ]);
    }
    // public function dropdown(Request $request)

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SiteMaster  $siteMaster
     * @return \Illuminate\Http\Response
     */
    public function show($site_no)
    {
        $data = SiteMaster::where('site_no', $site_no)->first();
        return view("sitemaster.index")->with([
            "data" => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SiteMaster  $siteMaster
     * @return \Illuminate\Http\Response
     */
    public function edit($site_no)
    {
        // info($site_no);
        // $data =SiteMaster::where('site_no', $site_no)->first();
        // return view('sitemaster.index',['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SiteMaster  $siteMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $site_no)
    {
        info($request['site_no']);
        $data = SiteMaster::where('site_no', $request['site_no']);
        $this->validate($request, [

            'site_name' => 'required',
            'site_location' => 'required',
            'site_building' => 'required',
            'site_floor' => 'required',
            'room_number' => 'required',
            'site_address' => 'required',
            'site_manager' => 'required'
        ]);
        $input = $request->except(['_token', '_method']);
        $data->update($input);
        return redirect()->route("sitemaster.index")->with([
            "success" => "sitemaster updated successfully"
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SiteMaster  $siteMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy($site_no)
    {
        $data = SiteMaster::where('site_no', $site_no)->first();
        $data->delete();
        return redirect()->route("sitemaster.index")->with([
            "success" => "sitemaster deleted successfully"
        ]);
    }
}
