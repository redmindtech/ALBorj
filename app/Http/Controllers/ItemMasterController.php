<?php

namespace App\Http\Controllers;

use App\Models\ItemMaster;
use App\Models\SupplierMaster;

use Illuminate\Http\Request;

class ItemMasterController extends Controller
{
    public function getData() {

        $name = $_GET['name'];
        $data = SupplierMaster::where('name','LIKE',$name.'%')->get();
info($data);
        return $data;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = ItemMaster::all();
        return view('itemmaster.index')->with([
            'items' => $items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('itemmaster.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // info('hi');
        $this->validate($request, [

            'item_name' => 'required',
            'item_category' => 'required',
            'stock_type' => 'required',
            'item_type' => 'required',
            'supplier_name' => 'required',
            'supplier_code' => 'required',

        ]);
        $data = $request->except(['_token']);
        ItemMaster::create($data);
        return redirect()->route("itemmaster.index")->with([
            "success" => "Item added successfully"
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
        $item = ItemMaster::where('id', $id)->first();
        return view("itemmaster.show")->with([
            "item" => $item
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
        $item = ItemMaster::where('id', $id)->first();
        return view("itemmaster.edit")->with([
            "item" => $item

        ]);
    }

    public function edit_data(){
        $id=$_GET['id'];
        $data = ItemMaster::where('id',$id)->get();
        return $data;


    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {

        $this->validate($request, [

            'item_name' => 'required',
            'item_category' => 'required',
            'stock_type' => 'required',
            'item_type' => 'required',
            'supplier_name' => 'required',
            'supplier_code' => 'required',

        ]);

        $item = ItemMaster::where('id', $request['id'])->first();
        $input = $request->except(['_token', '_method']);
        $item->update($input);
        return redirect()->route("itemmaster.index")->with([
            "success" => "itemmaster updated successfully"
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
        $item = ItemMaster::where('id', $id)->first();
        $item->delete();
        return redirect()->route("itemmaster.index")->with([
            "success" => "Item deleted successfully"
        ]);
    }
}
