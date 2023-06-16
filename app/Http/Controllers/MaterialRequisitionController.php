<?php

namespace App\Http\Controllers;

use App\Models\MaterialRequisition;
use App\Http\Controllers\Controller;
use App\Models\MaterialRequisitionItem;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Models\ItemMaster;
use App\Models\EmployeeMaster;
use App\Models\ProjectMaster;
require_once(app_path('constants.php'));
class MaterialRequisitionController extends Controller
{    public function index(Request $request)
    {

        try {
            if ($request->session()->has('user')) {
            $item=ItemMaster::all();
            $item_name=$item->pluck('item_name');
            $employee=EmployeeMaster::all();
            $employee_name=$employee->pluck('firstname');
            $project = ProjectMaster::all();
            $project_name=$project->pluck('project_name');
            //$purchase_type = GRNPURCHASETYPE;
            $material = MaterialRequisition::join('project_masters', 'materials.project_id', '=', 'project_masters.project_no')
                ->join('employee_masters', 'materials.user_id', '=', 'employee_masters.id')
                ->select(
                    'materials.*',
                    'project_masters.*',
                    'employee_masters.*',
                     DB::raw('DATE(materials.date) as date')
                )
                ->where('materials.deleted', '0')
                ->get();
            return view('material.index')
                ->with([
                    //'purchase_type' => $purchase_type,
                    'materials' => $material,
                    'employee_name'=>$employee_name,
                    'project_name'=>$project_name,
                    'item_name' => $item_name
                ]);
            }
            else{
                return redirect("/");
            }
        } catch (Exception $e) {
            info($e);
            return redirect()->route('suppliermaster.index')->with('error', 'Error occured in the Material Requisition');
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

        try {
            $data = $request->only(MaterialRequisition::REQUEST_INPUTS);
            $material = MaterialRequisition::create($data);
            $material_items = $request->input('item_no') ?? null;
            $quantity = $request->input('quantity') ?? null;
          
            if (count($material_items) > 0) {
                foreach ($material_items as $key => $material_item) {
                    MaterialRequisitionItem::create([
                        'mr_no' => $material->mr_id,
                        'item_no' => $material_item,                      
                        'quantity' => $quantity[$key]
                    ]);
                }
            }

            return response()->json('Material Requisition created Successfully');

        } catch (Exception $e) {
            info($e);
            return response()->json('Error occured in material store');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        try {
            $mi = MaterialRequisition::join('project_masters', 'materials.project_id', '=', 'project_masters.project_no')
                ->join('employee_masters', 'materials.user_id', '=', 'employee_masters.id')
                ->select(
                    'materials.*',
                    'project_masters.*',
                    'employee_masters.*',
                    DB::raw('DATE(materials.date) as date'),
                    DB::raw('DATE(materials.reference_date) as reference_date')
                )
                ->where('materials.mr_id', $id)
                ->get();

            $mi_item = MaterialRequisitionItem::
                join('item_masters', 'material_requisition_item.item_no', '=', 'item_masters.id')
                ->select('material_requisition_item.*', 'item_masters.*')
                ->where('material_requisition_item.mr_no', $id)
                ->get();

            return response()->json([
                'mi' => $mi,
                'mi_item' => $mi_item
            ]);

        } catch (Exception $e) {
            info($e);
            return response()->json('Error occured in the material show');
        }
    }

    public function update(Request $request, $id)
    {

        try {
            $grn = MaterialRequisition::where('mr_id', $id)->first();
            $grn->update($request->only(MaterialRequisition::REQUEST_INPUTS));
            // update the material item data
            $itemCount = count($request['item_no']);
            $grn_delete = MaterialRequisitionItem::where('mr_no', $id)->delete();
            for ($i = 0; $i < $itemCount; $i++) {
                MaterialRequisitionItem::create([
                    'mr_no' => $id,
                    'item_no' => $request['item_no'][$i],                    
                    'quantity' => $request['quantity'][$i],

                ]);
            }
            return response()->json('Material Requisition updated successfully', 200);
        } catch (Exception $e) {
            info($e);
            return response()->json('Error occurred while updating material Requisition', 400);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $mi_item = MaterialRequisitionItem::where('mr_no', $id)->update(['deleted' => 1]);
            $mi = MaterialRequisition::where('mr_id', $id)->update(['deleted' => 1]);
            return response()->json('Material Requisition Deleted Successfully', 200);

        } catch (Exception $e) {
            info($e);
            return response()->json('Error occured in material destroy');
        }
    }

    }