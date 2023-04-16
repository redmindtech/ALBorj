<?php

namespace App\Http\Controllers;

use App\Models\ItemMaster;
use App\Models\SupplierMaster;

use Exception;
use App\Http\Requests\ItemRequest;
use Illuminate\Http\Request;
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
    $stock_type = STOCKTYPE;
        $items = ItemMaster::all();
        return view('itemmaster.index')->with([
            'items' => $items,
            'item_type'=>$item_type,
            'item_category'=>$item_category,
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
            $items = ItemMaster::findOrFail($id);
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
            $items = ItemMaster::findOrFail($id);
            $items->update($request->only(ItemMaster::REQUEST_INPUTS));
            return response()->json('Item Master Updated Successfully');

        } catch (Exception $e) {
            info($e);
            return response()->json('Error occured in the update', 400);
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
            $items = ItemMaster::findOrFail($id);
            $items->delete();
            return response()->json('Item Master Deleted Successfully', 200);

        } catch (Exception $e) {
            info($e);
            return response()->json('Error occured in the edit', 400);
        }
    }

}