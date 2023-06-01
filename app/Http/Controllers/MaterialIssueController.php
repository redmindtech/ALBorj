<?php

namespace App\Http\Controllers;
use App\Models\MaterialIssue;
use App\Models\MaterialIssueItem;
use App\Models\ProjectMaster;
use App\Models\SiteMaster;
use App\Models\ItemMaster;
use App\Models\EmployeeMaster;
use App\Models\MaterialRequisition;
use Exception;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\MaterialIssueRequest;


use Illuminate\Http\Request;
require_once(app_path('constants.php'));

class MaterialIssueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // autocomplete data from site name

    //don't touch that
    public function  getitemnamedata(){
      try{
        $itemname = $_GET['itemname'];
        info($itemname);
        $data = ItemMaster::where('item_name','LIKE',$itemname.'%')->get();
        info($data);

        return $data;
    }
     catch (Exception $e) {
        info($e);
        return response()->json('Error occured in the loading page', 400);
    }
}
    public function  getsitelocationdata(){
        $site_name = $_GET['site_name'];

        $data = SiteMaster::where('site_location','LIKE',$site_name.'%')->get();
        //info($data);

        return $data;
    }

    public function index()
    {
        try{
            $type = MATERIALTYPE;

        $material_issues = DB::table('material_issue_return')
             ->join('employee_masters', 'material_issue_return.receiving_employee', '=', 'employee_masters.id')
            ->join('project_masters', 'material_issue_return.project_no', '=', 'project_masters.project_no')
            ->select('employee_masters.*','project_masters.*', 'material_issue_return.*')
            ->get();
        return view('materialissue.index')->with([
            'material_issues' => $material_issues,
            'type' => $type,

        ]);

    }
    catch (Exception $e) {
        info($e);
        return response()->json('Error occured in the loading page', 400);
    }
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MaterialIssueRequest $request)
    {

        try {
            info($request);

            MaterialIssue::create($request->only(MaterialIssue::REQUEST_INPUTS));
            $mir_no= MaterialIssue::max('mir_no');

            for ($i = 0;$i <  count($request['item_no']); $i++) {

                MaterialIssueItem::create([

                    'mir_no' => $mir_no,
                    'item_no' => $request['item_no'][$i],
                    // 'item' => $request['item'][$i],
                    'store_room' => $request['store_room'][$i],
                    'item_quantity' => $request['item_quantity'][$i],
                ]);
            }

            //  MaterialIssueItem::create($val1);
            return response()->json('Material Issue Details Created Successfully', 200);

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
public function show($mir_no)
{
    try {
        $material_issue_return =  DB::table('material_issue_return')->select('mr_no')->where('material_issue_return.mir_no', $mir_no)->value('mr_no');
        if ($material_issue_return != '') {
        $material_issues = DB::table('material_issue_return')
            ->join('employee_masters', 'material_issue_return.receiving_employee', '=', 'employee_masters.id')
           ->join('project_masters', 'material_issue_return.project_no', '=', 'project_masters.project_no')
           ->join('materials', 'material_issue_return.mr_no', '=', 'materials.mr_id')

           ->select( 'employee_masters.*','project_masters.*', 'material_issue_return.*','materials.*',
           DB::raw('DATE(material_issue_return.issue_date) as issue_date'))
           ->where('material_issue_return.mir_no',$mir_no)
           ->get();
        }
        else{
            $material_issues = DB::table('material_issue_return')
            ->join('employee_masters', 'material_issue_return.receiving_employee', '=', 'employee_masters.id')
           ->join('project_masters', 'material_issue_return.project_no', '=', 'project_masters.project_no')
           ->select( 'employee_masters.*','project_masters.*', 'material_issue_return.*',
           DB::raw('DATE(material_issue_return.issue_date) as issue_date'))
           ->where('material_issue_return.mir_no',$mir_no)
           ->get();
        }
           $material_issues_item = DB::table('material_issue_return_item')
           ->join('item_masters', 'material_issue_return_item.item_no', '=', 'item_masters.id')
           ->join('material_issue_return', 'material_issue_return_item.mir_no', '=', 'material_issue_return.mir_no')
            ->select('material_issue_return_item.*', 'item_masters.*','material_issue_return.*')
            ->where('material_issue_return_item.mir_no', $mir_no)
            ->get();
        


        return response()->json([
            'material_issues' => $material_issues,
            'material_issues_item'=>$material_issues_item,
        ]);
    } catch (Exception $e) {
        info($e);
        return response()->json('Error occurred in the show', 400);
    }
}


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

       public function update(MaterialIssueRequest $request, $mir_no)
    {

        try {
            DB::beginTransaction();

            $material_issues = MaterialIssue::where('mir_no', $mir_no)->firstOrFail();
            $material_issues->update($request->only(MaterialIssue::REQUEST_INPUTS));

            // update the Material Issue item data
            $itemCount = count($request['item_no']);
            $mir_delete=MaterialIssueItem::where('mir_no',$mir_no)->delete();
            for ($i = 0; $i < $itemCount; $i++) {
                MaterialIssueItem::create([
                    'mir_no'=>$mir_no,
                    // 'item' => $request['item'][$i],
                    'item_no' => $request['item_no'][$i],
                    'store_room' => $request['store_room'][$i],
                    'item_quantity' => $request['item_quantity'][$i],
                ]);

            }
            DB::commit();
            return response()->json('Materialissue Details Updated Successfully', 200);
        } catch (Exception $e) {
            DB::rollback();
            info($e);
            return response()->json('Error occurred in the update', 400);
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function destroy($mir_no){
        try {
            // Disable foreign key check
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            $material_issues = MaterialIssue::where('mir_no', $mir_no)->first();

            if ($material_issues != null) {
                $material_issues_items = MaterialIssueItem::where('mir_item_no', $mir_no)->get();

                foreach ($material_issues_items as $material_issues_item) {
                    $material_issues_item->delete();
                }

                $material_issues->delete();

                // Enable foreign key check
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');

                return response()->json('Material Details Deleted Successfully', 200);
            } else {
                // Enable foreign key check
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');

                return response()->json('Material not found', 404);
            }
        } catch (Exception $e) {
            // Enable foreign key check
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            info($e);
            return response()->json('Error occurred in the delete', 400);
        }
    }


}
