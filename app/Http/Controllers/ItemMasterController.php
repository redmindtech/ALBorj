<?php

namespace App\Http\Controllers;

use App\Models\ItemMaster;
use App\Models\SupplierMaster;
use App\Models\ItemSupplier;
use Exception;
use App\Http\Requests\ItemRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
require_once(app_path('constants.php'));
class ItemMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // FOR MAIN PAGE
    public function  getempdata()
    {

        $suppliername = $_GET['suppliername'];
        $data = SupplierMaster::where('name','LIKE',$suppliername.'%')->get();

        return $data;
    }


    public function index()
    {
        try{
            $item_type = ITEMTYPE;
            $item_category = ITEMCATEGORY;
            $item_subcategory = ITEMSUBCATEGORY;
            $stock_type = STOCKTYPE;
            $items = DB::table('item_masters')
            ->get();

                // info($items);
                return view('itemmaster.index')->with([
                    'items' => $items,
                    'item_type'=>$item_type,
                    'item_category'=>$item_category,'
                    item_subcategory'=>$item_subcategory,
                    'stock_type'=>$stock_type
                ]);

            }
            catch (Exception $e) {
                info($e);
                return response()->json('Error occured in the loading page', 400);
            }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // DATA SAVE IN ADD DIALOG
    public function store(ItemRequest $request)
    {
        try {
            // Create the item master
            $itemMaster = ItemMaster::create($request->only(ItemMaster::REQUEST_INPUTS));

            // Check if supplier_no is provided
            $supplierNo = $request->input('supplier_no');
            $quantity = $request->input('total_quantity');
            if ($supplierNo != null && $quantity != null ) {
                // Create the item supplier if supplier_no is not null
                $request['item_no'] = $itemMaster->id;
                $request['quantity'] = $request['total_quantity'];
                ItemSupplier::create($request->only(ItemSupplier::REQUEST_INPUTS));
            }

            return response()->json('Item Details Added Successfully', 200);
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
    // DATA SHOW WHICH IS USED FOR EDIT AND SHOW
    public function show($id)
    {

     try {
         $item =  DB::table('item_supplier')->select('supplier_no')->where('item_supplier.item_no', $id)->value('supplier_no');
           info($item);
          $items = DB::table('item_masters')
            ->join('item_supplier', 'item_masters.id', '=', 'item_supplier.item_no')
            ->join('supplier_masters', 'item_supplier.supplier_no', '=', 'supplier_masters.supplier_no')
            ->select('item_masters.*', 'item_supplier.*','supplier_masters.*')
            ->where('item_masters.id', $id)
            ->get();

    if ($item != "" ){
        $itemsupplier = ItemMaster::join('item_supplier', 'item_supplier.item_no', '=', 'item_masters.id')
        ->join('supplier_masters', 'item_supplier.supplier_no', '=', 'supplier_masters.supplier_no')
        ->select('item_masters.*', 'item_supplier.*', 'supplier_masters.*')
        ->where('item_masters.id', $id)
        ->get();

        }else {

            $itemsupplier = ItemMaster::where('id', $id)
            ->get();
        }
      return response()->json([
        'items' => $items,
        'itemsupplier' => $itemsupplier
    ]);
    info($items);
    info($itemsupplier);
        } catch (Exception $e) {
            info($e);
            return response()->json('Error occured in the show', 400);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // UPDATE SAVE FUNCTION
    public function update(ItemRequest $request, $id)
{
    try {
        // Update the item master
        $itemMaster = ItemMaster::findOrFail($id);
        $itemMaster->update($request->only(ItemMaster::REQUEST_INPUTS));

        // Update or create the item supplier if supplier_no and total_quantity are provided
        $supplierNo = $request->input('supplier_no');
        $quantity = $request->input('total_quantity');
        if ($supplierNo !== null && $quantity !== null) {
            $itemSupplierData = $request->only(ItemSupplier::REQUEST_INPUTS);
            $request['quantity'] = $request['total_quantity'];
            $itemSupplierData['item_no'] = $id;

            ItemSupplier::updateOrCreate(['item_no' => $id], $itemSupplierData);
        }

        return response()->json('Item Details Updated Successfully', 200);
    } catch (Exception $e) {
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
    // DELETE FUNCTION
    public function destroy($id)
    {
        try {
            // Find the item master
            $itemMaster = ItemMaster::findOrFail($id);
    
            // Find and delete the associated item supplier, if it exists
            $itemSupplier = ItemSupplier::where('item_no', $id)->first();
            if ($itemSupplier !== null) {
                $itemSupplier->delete();
            }
    
            // Delete the item master
            $itemMaster->delete();
    
            return response()->json('Item Details Deleted Successfully', 200);
        } catch (Exception $e) {
            info($e);
            return response()->json('Error occurred during delete', 400);
        }
    }
    
}