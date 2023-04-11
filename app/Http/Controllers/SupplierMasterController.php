<?php

namespace App\Http\Controllers;
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
    public function index()
    {
    try{
        $supplier = SupplierMaster::all();
        return view('suppliermaster.index')->with([
            'suppliers' => $supplier
        ]);
    }
    catch (Exception $e)
      {
        INFO($e);
        return redirect()->route("suppliermaster.index")->with([
            "error" => "An error occurred: " . $e
        ]);
     }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      try{
        return view('suppliermaster.create');
      }
      catch (Exception $e)
      {
            INFO($e);
            return redirect()->route("suppliermaster.index")->with([
                "error" => "An error occurred: " . $e
            ]);
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
        try{
            $this->validate($request, [
            'name' => 'required',
            'company_name' => 'required',
            'code'=>'',
            'address' => 'required',
            'contact_number' => 'required',
            'mail_id'=>'required',
            'website'=>'required',

        ]);
            $data = $request->except(['_token']);
            SupplierMaster::create($data);
            return redirect()->route("suppliermaster.index")->with([
                "success" => "Supplier details has been added successfully!"
            ]);
         }
    catch (Exception $e)
      {
        INFO($e);
        return redirect()->route("suppliermaster.index")->with([
            "error" => "An error occurred: " . $e
        ]);
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
        try
        {
            $supplier = SupplierMaster::where('supplier_no', $id)->first();
            return view("suppliermaster.show", ['supplier' => $supplier, 'show' => true])->with([
                "suppliers" => $supplier
            ]);
        }
        catch (Exception $e)
        {
            INFO($e);
            return redirect()->route("suppliermaster.index")->with([
                "error" => "An error occurred: " . $e
            ]);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {  try
        {
            $supplier = SupplierMaster::where('supplier_no', $id)->first();
            return view("suppliermaster.edit")->with([
                "suppliers" => $supplier

            ]);
        }
        catch (Exception $e)
        {
            INFO($e);
            return redirect()->route("suppliermaster.index")->with([
                "error" => "An error occurred: " . $e
            ]);
        }

    }
    public function supplier_edit_data(){
        try{
            $id=$_GET['id'];

            $data = SupplierMaster::where('supplier_no', $id)->get();

            return $data;
        }
        catch (Exception $e)
        {
            INFO($e);
            return redirect()->route("suppliermaster.index")->with([
                "error" => "An error occurred: " . $e
            ]);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try
        {
        $supplier = SupplierMaster::where('supplier_no', $request['supplier_no'])->first();
        $this->validate($request, [
        'name' => 'required',
        'company_name' => 'required',
        'address' => 'required',
        'contact_number' => 'required',
        'mail_id'=>'required',
        'website'=>'required',


        ]);

        $data = $request->except(['_token', '_method']);
        $supplier->update($data);

        return redirect()->route("suppliermaster.index")->with([
            "success" => "Supplier details has been updated!"
        ]);
        }
        catch (Exception $e)
        {
            INFO($e);
            return redirect()->route("suppliermaster.index")->with([
                "error" => "An error occurred: " . $e
            ]);
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
        try{
        $supplier = SupplierMaster::where('supplier_no', $id)->first();
        $supplier->delete();
        return redirect()->route("suppliermaster.index")->with([
            "success" => "Supplier details has been deleted successfully"
        ]);
    }
    catch (Exception $e)
        {
            INFO($e);
            return redirect()->route("suppliermaster.index")->with([
                "error" => "An error occurred: " . $e
            ]);
        }

}



}