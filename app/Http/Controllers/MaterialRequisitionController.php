<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaterialRequest;
use App\Models\MaterialRequisition;
use App\Http\Controllers\Controller;
use App\Models\MaterialRequisitionItem;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
require_once(app_path('constants.php'));
class MaterialRequisitionController extends Controller
{    public function index()
    {

        try {
            $purchase_type = GRNPURCHASETYPE;
            $material = MaterialRequisition::join('project_masters', 'materials.project_id', '=', 'project_masters.project_no')
                ->join('employee_masters', 'materials.user_id', '=', 'employee_masters.id')
                ->select(
                    'materials.*',
                    'project_masters.*',
                    'employee_masters.*',
                    DB::raw('DATE(materials.date) as date'),
                    DB::raw('DATE(materials.reference_date) as reference_date')
                )
                ->where('materials.deleted', '0')
                ->get();
            return view('material.index')
                ->with([
                    'purchase_type' => $purchase_type,
                    'materials' => $material
                ]);
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
    public function store(MaterialRequest $request)
    {

        try {
            $data = $request->only(MaterialRequisition::REQUEST_INPUTS);
            $material = MaterialRequisition::create($data);
            $material_items = $request->input('item_no') ?? null;
            $quantity = $request->input('quantity') ?? null;
            $stock_qty = $request->input('stock_qty') ?? null;
            if (count($material_items) > 0) {
                foreach ($material_items as $key => $material_item) {
                    MaterialRequisitionItem::create([
                        'mr_no' => $material->mr_id,
                        'item_no' => $material_item,
                        'stock_qty' => $stock_qty[$key],
                        'quantity' => $quantity[$key]
                    ]);
                }
            }

            return response()->json('Material Requisition is created Successfully');

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


    public function update(MaterialRequest $request, $id)
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
                    'stock_qty' => $request['stock_qty'][$i],
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
            return response()->json('Material Deleted Successfully', 200);

        } catch (Exception $e) {
            info($e);
            return response()->json('Error occured in material destroy');
        }
    }

    }
