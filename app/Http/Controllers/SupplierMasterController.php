<?php

namespace App\Http\Controllers;
use App\Models\SupplierMaster;

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
        //
        $supplier = SupplierMaster::all();
        return view('suppliermaster.index')->with([
            'suppliers' => $supplier
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('suppliermaster.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            //'supplier_no' => 'required',
            'name' => 'required',
            'company_name' => 'required',
            // 'code' => 'required',
            'address' => 'required',
            'contact_number' => 'required',
            'mail_id'=>'required',

        ]);
        $data = $request->except(['_token']);
        SupplierMaster::create($data);
        return redirect()->route("suppliermaster.index")->with([
            "success" => "Supplier details has been added successfully!"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $supplier = SupplierMaster::where('supplier_no', $id)->first();
        return view("suppliermaster.show", ['supplier' => $supplier, 'show' => true])->with([
            "suppliers" => $supplier
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier = SupplierMaster::where('supplier_no', $id)->first();
        return view("suppliermaster.edit")->with([
            "suppliers" => $supplier

        ]);
    }
    public function supplier_edit_data(){
        // info('edit');
        $id=$_GET['id'];
        // info($id);
        // $data = SupplierMaster::where('supplier_no',$id)->all();
        $data = SupplierMaster::where('supplier_no', $id)->get();
        //  info($data);
        return $data;


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
        // info($request['supplier_no']);
        $supplier = SupplierMaster::where('supplier_no', $request['supplier_no'])->first();
        $this->validate($request, [
         //   'id'=> '|unique:supplier,id,' . $supplier->id,
        //'supplier_no' => 'required',
        'name' => 'required',
        'company_name' => 'required',
        // 'code' => 'required',
        'address' => 'required',
        'contact_number' => 'required',
        'mail_id'=>'required',

        ]);

        $data = $request->except(['_token', '_method']);
        $supplier->update($data);

        return redirect()->route("suppliermaster.index")->with([
            "success" => "Supplier details has been updated!"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = SupplierMaster::where('supplier_no', $id)->first();
        $supplier->delete();
        return redirect()->route("suppliermaster.index")->with([
            "success" => "Supplier details has been deleted successfully"
        ]);
    }
    public function storeOrUpdate(Request $request, $id)
{
    if($request->input('action') == 'add') {
        // Create a new supplier
        $supplier = new SupplierMaster();
        $supplier->name = $request->input('name');
        // Set other fields
        $supplier->save();
    } else {
        // Update an existing supplier
        $supplier = SupplierMaster::find($request->input('supplier_no'));
        $supplier->name = $request->input('name');
        // Set other fields
        $supplier->save();
    }

    // Redirect to the suppliers index page or return a response
}

}
