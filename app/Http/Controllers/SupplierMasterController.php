<?php

namespace App\Http\Controllers;
use App\Models\ItemSupplier;
use App\Models\SupplierMaster;
use Exception;
use Illuminate\Http\Request;

class SupplierMasterController extends Controller
{
    
    // FOR MAIN PAGE
    public function index()
    {
        try
        {
            if (session()->has('user')) {
                $supplier = SupplierMaster::where('deleted', 0)
                ->get();            
            $contact_number= $supplier->pluck('contact_number');
            return view('suppliermaster.index')->with([
                'suppliers' => $supplier,
                'contact_number'=>$contact_number

            ]);
        }else{
            return redirect("/");
        }
        }
        catch (Exception $e) 
        {
                info($e);
                return response()->json('Error occured in the loading page', 400);
        }

    }



   
    // DATA SAVE IN ADD DIALOG
    public function store(Request $request)
    {
        try 
        {

            SupplierMaster::create($request->only(SupplierMaster::REQUEST_INPUTS));
            return response()->json('Supplier Details Added Successfully', 200);

        } 
        catch (Exception $e) 
        {
            info($e);
            return response()->json('Error occured in the store', 400);
        }
    }

    
    // DATA SHOW WHICH IS USED FOR EDIT AND SHOW
    public function show($id)
    {
        try 
        {
            $supplier = SupplierMaster::findOrFail($id);
            return response()->json($supplier);

        } 
        catch (Exception $e) 
        {
            info($e);
            return response()->json('Error occured in the show', 400);
        }
    }

  
    // UPDATE SAVE FUNCTION
    public function update(Request $request, $id)
    {
        try 
        {
            $supplier = SupplierMaster::findOrFail($id);
            $supplier->update($request->only(SupplierMaster::REQUEST_INPUTS));
            return response()->json('Supplier Details Updated Successfully');

        } 
        catch (Exception $e) 
        {
            info($e);
            return response()->json('Error occured in the update', 400);
        }

    }

    // DELETE FUNCTION
    public function destroy($id)
    {
       

        try 
        {
            $supplier = SupplierMaster::findOrFail($id);
            $item = ItemSupplier::where('supplier_no', $id)->first();
            if ($item) {
                return response()->json('Cannot delete this supplier. It is associated with a item.', 200);
            }
            $supplier->update(['deleted'=>'1']);
            return response()->json('Supplier Details Deleted Successfully', 200);
           
        } 
        catch (Exception $e) 
        {
            info($e);
            return response()->json('Error occured in the delete', 400);
        }
    }
    // SOA for supplier from payables
    public function soa($id)
    {
       $supplierData = SupplierMaster::where('supplier_masters.supplier_no', $id)
       ->join('goods_received_note', 'supplier_masters.supplier_no', '=', 'goods_received_note.supplier_no')
       ->join('payment_payable', 'goods_received_note.project_no', '=', 'goods_received_note.project_no')
       ->get(['supplier_masters.supplier_no', 'supplier_masters.name', 'payment_payable.*','goods_received_note.total_amount']);

      return response()->json($supplierData);
}
}