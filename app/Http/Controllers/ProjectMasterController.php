<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectMaster;
use App\Models\SiteMaster;
use App\Models\EmployeeMaster;
use Illuminate\Support\MessageBag;


class ProjectMasterController extends Controller
{
    public function ProjectGetData() {

        $site_name = $_GET['site_name'];
        $data = SiteMaster::where('site_name','LIKE',$site_name.'%')->get();
        info($data);
        return $data;
    }
    public function ProjectManagerData() {

        $manager_name = $_GET['manager_name'];
        $data = EmployeeMaster::where('firstname','LIKE',$manager_name.'%')->get();
        info($data);
        return $data;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = ProjectMaster::all();
        return view('projectmaster.index')->with([
            'projects' => $projects
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projectmaster.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        info($request);
        $this->validate($request, [
        'site_no'=>'required',
         'site_name'=>'required',
         'project_name'=>'required',
         'project_type'=>'required',
         'project_comments'=>'required',
         'manager_name'=>'required',
         'manager_contact_number'=>'required',
         'company_name'=>'required',
         'client_contact_name'=>'required',
         'client_contact_number'=>'required',
         'consultant_name'=>'required',
         'start_date'=>'required',
         'end_date'=>'required',
         'actual_project_end_date'=>'required',
         'status'=>'required',
         'total_price_cost'=>'required',
         'advanced_amount'=>'required',
         'retention'=>'required',
         'amount_to_be_received'=>'required',
         'amount_return'=>'required',
         'amount_return_date'=>'required',
         'amount_returns_comment'=>'required'

        ]);
        $data = $request->only(['site_no',
        'site_name',
        'project_name',
        'project_type',
        'project_comments',
        'manager_name',
        'manager_contact_number',
        'company_name',
        'client_contact_name',
        'client_contact_number',
        'consultant_name',
        'start_date',
        'end_date',
        'actual_project_end_date',
        'status',
        'total_price_cost',
        'advanced_amount',
        'retention',
        'amount_to_be_received',
        'amount_return',
        'amount_return_date',
        'amount_returns_comment']);
        info($data);
        ProjectMaster::create($data);
        return redirect()->route("projectmaster.index")->with([
            "success" => "Project added successfully"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $project_no
     * @return \Illuminate\Http\Response
     */
    public function show($project_no)
    {
        $project = ProjectMaster::where('project_no', $project_no)->first();
        return view("projectmaster.show")->with([
            "projects" => $project
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $project_no
     * @return \Illuminate\Http\Response
     */
    public function edit($project_no)
    {

        $project =ProjectMaster::find($project_no);
        info($project);
        return view('projectmaster.edit',['projects' => $project]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $project_no
     * @return \Illuminate\Http\Response
     */
    public function project_data()
    {

        $id=$_GET['project_no'];
        info($id);
        $data = ProjectMaster::where('project_no', $id)->get();
        info($data);
        return $data;
   }



    public function update(Request $request, $project_no)
    {

        $project = ProjectMaster::where('project_no', $request['project_no']);
        $this->validate($request, [
         'site_no'=>'required',
         'site_name'=>'required',
         'project_name'=>'required',
         'project_type'=>'required',
         'project_comments'=>'required',
         'manager_name'=>'required',
         'manager_contact_number'=>'required',
         'company_name'=>'required',
         'client_contact_name'=>'required',
         'client_contact_number'=>'required',
         'consultant_name'=>'required',
         'start_date'=>'required',
         'end_date'=>'required',
         'actual_project_end_date'=>'required',
         'status'=>'required',
         'total_price_cost'=>'required',
         'advanced_amount'=>'required',
         'retention'=>'required',
         'amount_to_be_received'=>'required',
         'amount_return'=>'required',
         'amount_return_date'=>'required',
         'amount_returns_comment'=>'required'

        ]);
        $input = $request->except(['_token', '_method']);
        $project->update($input);
        return redirect()->route("projectmaster.index")->with([
            "success" => "Project updated successfully"
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $project_no
     * @return \Illuminate\Http\Response
     */
    public function destroy($project_no)
    {
        $project = ProjectMaster::where('project_no', $project_no)->first();
        $project->delete();
        return redirect()->route("projectmaster.index")->with([
            "success" => "Project deleted successfully"
        ]);
    }
}
