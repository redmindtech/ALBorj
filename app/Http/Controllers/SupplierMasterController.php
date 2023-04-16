<?php

namespace App\Http\Controllers;

use App\Models\SupplierMaster;
use Exception;
use App\Http\Requests\SupplierRequest;
use Illuminate\Http\Request;

class SupplierMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // FOR MAIN PAGE
    public function index()
    {
    try{
        $supplier = SupplierMaster::all();
        return view('suppliermaster.index')->with([
            'suppliers' => $supplier
        ]);}
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
    public function store(SupplierRequest $request)
    {
        try {

            SupplierMaster::create($request->only(SupplierMaster::REQUEST_INPUTS));
            return response()->json('Supplier Master Created Successfully', 200);

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
            $supplier = SupplierMaster::findOrFail($id);
            return response()->json($supplier);

        } catch (Exception $e) {
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
    public function update(SupplierRequest $request, $id)
    {
        try {
            $supplier = SupplierMaster::findOrFail($id);
            $supplier->update($request->only(SupplierMaster::REQUEST_INPUTS));
            return response()->json('Supplier Master Updated Successfully');

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
            $supplier = SupplierMaster::findOrFail($id);
            $supplier->delete();
            return response()->json('Supplier Master Deleted Successfully', 200);

        } catch (Exception $e) {
            info($e);
            return response()->json('Error occured in the edit', 400);
        }
    }


}