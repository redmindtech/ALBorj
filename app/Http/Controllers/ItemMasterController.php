<?php

namespace App\Http\Controllers;

use App\Models\ItemMaster;
use App\Models\SupplierMaster;
use App\Models\ItemSupplier;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
require_once(app_path('constants.php'));
class ItemMasterController extends Controller
{
    // FOR MAIN PAGE
    public function index()
    {   
        try{
            if (session()->has('user')) {
            $item_type = ITEMTYPE;
            $item_category = ITEMCATEGORY;
            $item_subcategory = ITEMSUBCATEGORY;
            $stock_type = STOCKTYPE;
            $supplier_company = SupplierMaster::where('deleted', 0)
            ->pluck('company_name');
        
            $items = ItemMaster::where('deleted', 0)
            ->get();
        
            $itemName = $items->where('deleted', 0)
            ->pluck('item_name')
            ->map(function ($name) {
                return strtolower(str_replace(' ', '', $name));
            });
        
            $items = ItemMaster::where('deleted', 0)
            ->get();
            
            return view('itemmaster.index')->with([
                    'items' => $items,
                    'item_type'=>$item_type,
                    'item_category'=>$item_category,
                    'item_subcategory'=>$item_subcategory,
                    'stock_type'=>$stock_type,
                    'itemName'=>$itemName,
                    'supplier_company'=>$supplier_company
                ]);
            }else{
                return redirect("/");
            }
            }
            catch (Exception $e) {
                info($e);
                return response()->json('Error occured in the loading page', 400);
            }
    }


    
    // DATA SAVE IN ADD DIALOG
    public function store(Request $request)
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
    
    // DATA SHOW WHICH IS USED FOR EDIT AND SHOW
    public function show($id)
    {

         try {
                $items = DB::table('item_masters')
                    ->join('item_supplier', 'item_masters.id', '=', 'item_supplier.item_no')
                    ->join('supplier_masters', 'item_supplier.supplier_no', '=', 'supplier_masters.supplier_no')
                    ->select('item_masters.*', 'item_supplier.*','supplier_masters.*')
                    ->where('item_masters.id', $id)
                    ->get();
                
                $item = DB::table('item_supplier')->select('supplier_no')->where('item_no', $id)->value('supplier_no');
                
                if ($item != "") {
                    $itemsupplier = ItemMaster::join('item_supplier', 'item_supplier.item_no', '=', 'item_masters.id')
                        ->join('supplier_masters', 'item_supplier.supplier_no', '=', 'supplier_masters.supplier_no')
                        ->select('item_masters.*', 'item_supplier.*', 'supplier_masters.*')
                        ->where('item_masters.id', $id)
                        ->orderBy('item_supplier.sno', 'desc')
                        ->get();
                } else {
                    $itemsupplier = ItemMaster::where('id', $id)
                        ->get();
                }
                
                return response()->json([
                    'items' => $items,
                    'itemsupplier' => $itemsupplier
                ]);


    
    
        } catch (Exception $e) {
            info($e);
            return response()->json('Error occured in the show', 400);
        }
    }


    
    // UPDATE SAVE FUNCTION
    public function update(Request $request, $id)
{
    try {
        // Update the item master
        $itemMaster = ItemMaster::findOrFail($id);
        $itemMaster->update($request->only(ItemMaster::REQUEST_INPUTS));

        // Check if supplier_no and total_quantity are provided
        $supplierNo = $request->input('supplier_no');
        $quantity = $request->input('total_quantity');

        if ($supplierNo !== null && $quantity !== null) {
            // Check if the item supplier already exists
            $existingItemSupplier = ItemSupplier::where('item_no', $id)
                ->where('supplier_no', $supplierNo)
                ->first();
  
                if ($existingItemSupplier) {
                         // Item supplier already exists
                         $existingQuantity = $existingItemSupplier->quantity;
                         if ($existingQuantity != $quantity) {
                             // Update the quantity only if it's different from the existing quantity
                             $newQuantity = $existingQuantity + $quantity;
                             $existingItemSupplier->update(['quantity' => $newQuantity]);
                             
                         }
                         else if($existingQuantity == $quantity){
                            
                         }
                } else {
                    // Item supplier doesn't exist, create a new one
                    $itemSupplierData = $request->only(ItemSupplier::REQUEST_INPUTS);
                    $itemSupplierData['item_no'] = $id;
                    $itemSupplierData['quantity'] = $quantity;
    
                    ItemSupplier::create($itemSupplierData);
                }

                 // Calculate the total quantity by summing up the quantities of all suppliers
            $totalQuantity = ItemSupplier::where('item_no', $id)->sum('quantity');

            // Update the total_quantity in the item master
            $itemMaster->update(['total_quantity' => $totalQuantity]);

        } else if ($supplierNo !== null) {
            // Remove the existing item supplier
            ItemSupplier::where('item_no', $id)
                ->where('supplier_no', $supplierNo)
                ->delete();
                 // Calculate the total quantity by summing up the quantities of all suppliers
            $totalQuantity = ItemSupplier::where('item_no', $id)->sum('quantity');

            // Update the total_quantity in the item master
            $itemMaster->update(['total_quantity' => $totalQuantity]);
        }

        return response()->json('Item Details Updated Successfully', 200);
    } catch (Exception $e) {
        info($e);
        return response()->json('Error occurred in the update', 400);
    }
}


    // DELETE FUNCTION
    public function destroy($id)
    {
        try {
            // Find the item master
            $itemMaster = ItemMaster::findOrFail($id);
    
            // Find and delete the associated item supplier, if it exists
            $itemSupplier = ItemSupplier::where('item_no', $id)->first();
            if ($itemSupplier !== null) {
                return response()->json('Cannot delete this item. It is associated with a itemsupplier.',200);
                // $itemSupplier->update('deleted','1');
            }           
            // Delete the item master
            $itemMaster->update(['deleted'=>'1']);
    
            return response()->json('Item Details Deleted Successfully', 200);
        } catch (Exception $e) {
            info($e);
            return response()->json('Error occurred during delete', 400);
        }
    }
    
}