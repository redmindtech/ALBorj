<?php

namespace App\Http\Controllers;
use App\Models\ItemSupplier;
use App\Models\SupplierMaster;
use Exception;
use Illuminate\Http\Request;

class SupplierMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // FOR MAIN PAGE
    public function index(Request $request)
    {
        try
        {
            if ($request->session()->has('user')) {
            $supplier = SupplierMaster::all();
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



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // DELETE FUNCTION
    public function destroy($id)
    {
        info($id);

        try 
        {
            $supplier = SupplierMaster::findOrFail($id);
            $item = ItemSupplier::where('supplier_no', $id)->first();
            if ($item) {
                return response()->json('Cannot delete this supplier. It is associated with a item.', 200);
            }
            $supplier->delete();
            return response()->json('Supplier Details Deleted Successfully', 200);
           
        } 
        catch (Exception $e) 
        {
            info($e);
            return response()->json('Error occured in the delete', 400);
        }
    }
}