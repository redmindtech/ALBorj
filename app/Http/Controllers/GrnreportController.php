<?php


namespace App\Http\Controllers;

use App\Models\ItemMaster;
use App\Models\SupplierMaster;
use App\Models\ItemSupplier;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GrnreportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            if (session()->has('user')) {
            $items = DB::table('item_masters')
                ->select('item_supplier.*', 'item_masters.*', 'supplier_masters.name', DB::raw('item_supplier.quantity * item_supplier.price_per_qty as total_price'))
                ->join('item_supplier', 'item_supplier.item_no', '=', 'item_masters.id')
                ->join('supplier_masters', 'item_supplier.supplier_no', '=', 'supplier_masters.supplier_no')
                ->where('item_masters.deleted', 0)
                ->where('item_supplier.deleted', 0)
                ->get();

            $totalAmount = $items->sum('total_price'); // Calculate the total amount
            $totalquant = $items->sum('quantity');

            return view('grninventoryreport.index')->with([
                'items' => $items,
                'totalAmount' => $totalAmount, // Pass the total amount to the view
                'totalquant' => $totalquant,
            ]);
        }else{
            return redirect("/");
        }
        } catch (Exception $e) {
            info($e);
            return response()->json('An error occurred while loading the page', 400);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}