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
    public function  getempdata(){

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

                info($items);
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

            ItemMaster::create($request->only(ItemMaster::REQUEST_INPUTS));
            $request['item_no']=ItemMaster::max('id');
            ItemSupplier::create($request->only(ItemSupplier::REQUEST_INPUTS));
            return response()->json('Item Master Created Successfully', 200);

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
    // DATA SHOW WHICH IS USED FOR EDIT AND SHOW
    public function show($id)
    {
        try {
            $items = DB::table('item_masters')
            ->join('item_supplier', 'item_masters.id', '=', 'item_supplier.item_no')
            ->join('supplier_masters', 'item_supplier.supplier_no', '=', 'supplier_masters.supplier_no')
            ->select('item_masters.*', 'item_supplier.*', 'supplier_masters.*')
            ->get();


             return response()->json($items);

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
            $itemMaster = ItemMaster::find($id);
            $itemMaster->update($request->only(ItemMaster::REQUEST_INPUTS));

            $itemSupplier = ItemSupplier::where('item_no', $id)->first();
            $itemSupplier->update($request->only(ItemSupplier::REQUEST_INPUTS));

            return response()->json('Item Master Updated Successfully', 200);
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
        // Disable foreign key check
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $itemMaster = ItemMaster::find($id);

        if ($itemMaster != null) {
            $itemSupplier = ItemSupplier::where('item_no', $id)->first();
            $itemSupplier->delete();

            $itemMaster->delete();

            // Enable foreign key check
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            return response()->json('Item Master Deleted Successfully', 200);
        } else {
            // Enable foreign key check
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            return response()->json('Item not found', 404);
        }
    } catch (Exception $e) {
        // Enable foreign key check
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        info($e);
        return response()->json('Error occurred in the delete', 400);
    }
}


}
