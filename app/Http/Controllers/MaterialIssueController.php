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
    public function index(Request $request)
    {
        try
        {
            if ($request->session()->has('user')) {
            $type = MATERIALTYPE;
            $site_location =SITELOCATION;
            // $siteLocation = SiteMaster::pluck('site_location');
            $projectNames=ProjectMaster::pluck('project_name');
            $employeeNames = EmployeeMaster::pluck('firstname');
            $itemNames = ItemMaster::pluck('item_name');

            $material_issues = DB::table('material_issue_return')
            // ->join('employee_masters', 'material_issue_return.receiving_employee', '=', 'employee_masters.id')

            ->join('project_masters', 'material_issue_return.project_no', '=', 'project_masters.project_no')
            ->select('project_masters.*', 'material_issue_return.*')
            ->where('material_issue_return.deleted','0')
            ->get();
            return view('materialissue.index')->with([
                'material_issues' => $material_issues,
                'type' => $type,
                'site_location' => $site_location,
                'projectNames' => $projectNames,
                'employeeNames' => $employeeNames,
                'itemNames' => $itemNames

            ]);
        }
        else {
            return response()->json('GRN not found', 404);
        }
        }
        catch (Exception $e)
        {
            info($e);
            return response()->json('Error occured in the loading page', 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function store(Request $request)
     {
         try {
             info($request);

             // Create MaterialIssue record
             $materialIssue = MaterialIssue::create($request->only(MaterialIssue::REQUEST_INPUTS));
             $mir_no = $materialIssue->mir_no;

             // Create MaterialIssueItem records
             for ($i = 0; $i < count($request['item_no']); $i++) {
                 MaterialIssueItem::create([
                     'mir_no' => $mir_no,
                     'item_no' => $request['item_no'][$i],
                     'store_room' => $request['store_room'][$i],
                     'item_quantity' => $request['item_quantity'][$i],
                 ]);

                 // Update total_quantity based on the selected type
                 $type = $request->input('type');
                 if ($type === 'Issue') {
                     // Reduce the total_quantity by item_quantity
                     $item = ItemMaster::find($request['item_no'][$i]);
                     $item->total_quantity -= $request['item_quantity'][$i];
                     $item->save();
                 } elseif ($type === 'Return') {
                     // Add the item_quantity to total_quantity
                     $item = ItemMaster::find($request['item_no'][$i]);
                     $item->total_quantity += $request['item_quantity'][$i];
                     $item->save();
                 }
             }

             // Return appropriate response based on the selected type
             if ($type === 'Issue') {
                 return response()->json('Material Issue added Successfully', 200);
             } elseif ($type === 'Return') {
                 return response()->json('Material Return added Successful', 200);
             } else {
                 return response()->json('Operation Successful', 200);
             }
         } catch (Exception $e) {
             info($e);
             return response()->json('Error occurred in the store', 400);
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
        try
        {
            $material_issue_return = DB::table('material_issue_return')
                ->select('mr_no')
                ->where('material_issue_return.mir_no', $mir_no)
                ->value('mr_no');

            if ($material_issue_return != '')
            {
                info("gowtham");
                $material_issues = DB::table('material_issue_return')
                // ->join('employee_masters', 'material_issue_return.receiving_employee', '=', 'employee_masters.id')
                ->join('project_masters', 'material_issue_return.project_no', '=', 'project_masters.project_no')
                ->join('materials', 'material_issue_return.mr_no', '=', 'materials.mr_id')
                ->select('project_masters.*', 'material_issue_return.*', 'materials.*', DB::raw('DATE(material_issue_return.issue_date) as issue_date'))
                ->where('material_issue_return.mir_no', $mir_no)
                ->get();

                $material_issues_item = DB::table('material_issue_return_item')
                ->join('item_masters', 'material_issue_return_item.item_no', '=', 'item_masters.id')
                ->join('material_issue_return', 'material_issue_return_item.mir_no', '=', 'material_issue_return.mir_no')
                ->join('material_requisition_item', 'material_requisition_item.item_no', '=', 'item_masters.id')
                ->select('material_issue_return_item.*', 'item_masters.*', 'material_requisition_item.*','material_issue_return.*')
                ->where('material_issue_return_item.mir_no', $mir_no)
                ->where('material_requisition_item.mr_no', $material_issue_return) // Include separate where condition for mr_no
                ->get();

            } else
            {
                // info('sara');
                $material_issues = DB::table('material_issue_return')

                ->join('project_masters', 'material_issue_return.project_no', '=', 'project_masters.project_no')
                ->select('project_masters.*', 'material_issue_return.*', DB::raw('DATE(material_issue_return.issue_date) as issue_date'))
                ->where('material_issue_return.mir_no', $mir_no)
                ->get();
                $material_issues_item = DB::table('material_issue_return_item')
                ->join('item_masters', 'material_issue_return_item.item_no', '=', 'item_masters.id')
                ->join('material_issue_return', 'material_issue_return_item.mir_no', '=', 'material_issue_return.mir_no')
                 //->join('material_requisition_item', 'material_requisition_item.item_no', '=', 'item_masters.id')
                ->select('material_issue_return_item.*', 'item_masters.*', 'material_issue_return.*')
                ->where('material_issue_return_item.mir_no', $mir_no)
                // ->where('material_requisition_item.mr_no', $mr_no) // Include separate where condition for mr_no
                ->get();

            }
            if ($material_issues) {
                $material_issues = $material_issues->toArray();

                // Convert the data to UTF-8 encoding
                array_walk_recursive($material_issues, function (&$value) {
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


            // info($material_issues_item);

            return response()->json([
                'material_issues' => $material_issues,
                'material_issues_item' => $material_issues_item,
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function update(Request $request, $id)
     {
         try {
             // Find the MaterialIssue record
             $materialIssue = MaterialIssue::findOrFail($id);
             $mir_no = $id;

             // Update MaterialIssue record
            //  $materialIssue->update($request->only(MaterialIssue::REQUEST_INPUTS));

            //  // Delete existing MaterialIssueItem records
            //  $material = DB::table('material_issue_return_item')
            //          ->where('mir_no', $mir_no)
            //          ->get();
            //  MaterialIssueItem::where('mir_no', $mir_no)->delete();
             $type = $request->input('type');

             // Create MaterialIssueItem records
             for ($i = 0; $i < count($request['item_no']); $i++) {

                $material = DB::table('material_issue_return_item')
                ->where('mir_no', $mir_no)
                ->where('item_no',$request['item_no'][$i])
                ->value('item_quantity');
                info("sa".$material);
                //type
                $type_before=$request['type'];
                $type_actual = DB::table('material_issue_return')
                        ->select('type')
                        ->where('mir_no', $mir_no)
                         ->value('type');
                info($type_before);
                info("go".$type_actual);
                MaterialIssueItem::where('mir_no', $mir_no)
                ->where('item_no',$request['item_no'][$i])
                ->delete();
                //  foreach ($material as $materialItem) {
                     $itemQty = $material;
                    //  info($itemQty);
                    //  info($request['item_quantity']);
                    if ( $type_before!=$type_actual){
                        info($type_before);
                        if ( $type_before === 'Return'){
                            if ($itemQty != $request['item_quantity'][$i]) {
                        info('ss');
                            $item = ItemMaster::find($request['item_no'][$i]);
                            $item->total_quantity += $request['item_quantity'][$i]+$material;
                            // // $qty= $request['item_quantity'][$i]- $material;
                            //  $item->total_quantity += $qty;
                             $item->save();
                             MaterialIssueItem::create([
                                'mir_no' => $mir_no,
                                'item_no' => $request['item_no'][$i],
                                'store_room' => $request['store_room'][$i],
                                 'item_quantity' => $request['item_quantity'][$i],
                            ]);
                         }
                        else{
                            $item = ItemMaster::find($request['item_no'][$i]);
                            $item->total_quantity += $request['item_quantity'][$i];
                            // // $qty= $request['item_quantity'][$i]- $material;
                            //  $item->total_quantity += $qty;
                             $item->save();
                             MaterialIssueItem::create([
                                'mir_no' => $mir_no,
                                'item_no' => $request['item_no'][$i],
                                'store_room' => $request['store_room'][$i],
                                 'item_quantity' => $request['item_quantity'][$i],
                            ]);
                        }}
                         if ( $type_before === 'Issue'){
                            if ($itemQty != $request['item_quantity'][$i]) {
                            info('ss1');
                                $item = ItemMaster::find($request['item_no'][$i]);
                                $reduce=$item->total_quantity - $request['item_quantity'][$i];
                                $item->total_quantity =$reduce-$material;
                                // // $qty= $request['item_quantity'][$i]- $material;
                                //  $item->total_quantity += $qty;
                                 $item->save();
                                 MaterialIssueItem::create([
                                    'mir_no' => $mir_no,
                                    'item_no' => $request['item_no'][$i],
                                    'store_room' => $request['store_room'][$i],
                                     'item_quantity' => $request['item_quantity'][$i],
                                ]);
                             }else{
                                $item = ItemMaster::find($request['item_no'][$i]);
                                $item->total_quantity -= $request['item_quantity'][$i];
                                // // $qty= $request['item_quantity'][$i]- $material;
                                //  $item->total_quantity += $qty;
                                 $item->save();
                                 MaterialIssueItem::create([
                                    'mir_no' => $mir_no,
                                    'item_no' => $request['item_no'][$i],
                                    'store_room' => $request['store_room'][$i],
                                     'item_quantity' => $request['item_quantity'][$i],
                                ]);

                             }}

                    }
else{
                     if ($type === 'Issue'){

                     if ($itemQty != $request['item_quantity'][$i]) {
                        info('gowtham');

                             // Reduce the total_quantity by item_quantity
                             $item = ItemMaster::find($request['item_no'][$i]);
                            //  $item->total_quantity += $request['item_quantity'][$i];
                            $qty= $request['item_quantity'][$i]- $material;

                             $item->total_quantity -= $qty;
                             $item->save();
                             MaterialIssueItem::create([
                                'mir_no' => $mir_no,
                                'item_no' => $request['item_no'][$i],
                                'store_room' => $request['store_room'][$i],
                                 'item_quantity' => $request['item_quantity'][$i],
                            ]);}

                            else{
                                MaterialIssueItem::create([
                                    'mir_no' => $mir_no,
                                    'item_no' => $request['item_no'][$i],
                                    'store_room' => $request['store_room'][$i],
                                     'item_quantity' => $request['item_quantity'][$i],
                                ]);

                            }
                        }

                        if ($type === 'Return'){

                        if ($itemQty != $request['item_quantity'][$i]) {
                           info('gowtham2');

                                // Reduce the total_quantity by item_quantity
                                $item = ItemMaster::find($request['item_no'][$i]);
                               //  $item->total_quantity += $request['item_quantity'][$i];
                               $qty= $request['item_quantity'][$i]- $material;
                                $item->total_quantity += $qty;
                                $item->save();
                                MaterialIssueItem::create([
                                   'mir_no' => $mir_no,
                                   'item_no' => $request['item_no'][$i],
                                   'store_room' => $request['store_room'][$i],
                                    'item_quantity' => $request['item_quantity'][$i],
                               ]);}
                               else{
                                   MaterialIssueItem::create([
                                       'mir_no' => $mir_no,
                                       'item_no' => $request['item_no'][$i],
                                       'store_room' => $request['store_room'][$i],
                                        'item_quantity' => $request['item_quantity'][$i],
                                   ]);

                               }
                            }
                           }
             }
             $materialIssue->update($request->only(MaterialIssue::REQUEST_INPUTS));
             // Return appropriate response based on the selected type
             if ($type === 'Issue') {
                 return response()->json('Material Issue updated successfully', 200);
             } elseif ($type === 'Return') {
                 return response()->json('Material Return updated successfully', 200);
             } else {
                 return response()->json('Operation successful', 200);
             }

         } catch (Exception $e) {
             info($e);
             return response()->json('Error occurred during update', 400);
         }
     }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

   
    public function destroy($mir_no)
{
    try {
        $material_issues_items = MaterialIssueItem::where('mir_no', $mir_no)->update(['deleted' => 1]);
        $material_issues = MaterialIssue::where('mir_no', $mir_no)->update(['deleted' => 1]);
        return response()->json('Material issue/return Deleted Successfully', 200);
    } catch (Exception $e) {
        info($e);
        return response()->json('Error occurred in the delete', 400);
    }
}


}