<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\SupplierMaster;
use App\Models\ProjectMaster;
use App\Models\ItemMaster;
use App\Models\ItemSupplier;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
require_once(app_path('constants.php'));

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


     public function  getprojectname(){

        $projectname = $_GET['projectname'];
        $data = ProjectMaster::where('name','LIKE',$projectname.'%')->get();
        // info($data);
        return $data;
    }



    public function index()
    {

        try{
            $po_type = PROJECTORDERTYPE;
            $currency = CURRENCY;
            $purchase_orders =  DB::table('purchase_order')
            ->join('supplier_masters', 'purchase_order.supplier_no', '=', 'supplier_masters.supplier_no')
           ->join('project_masters', 'purchase_order.delivery_location', '=', 'project_masters.project_no')
           ->select( 'supplier_masters.*','project_masters.*', 'purchase_order.*')

           ->get();
        //    info($purchase_orders);

            return view('purchaseorder.index')->with([
                'purchase_orders' => $purchase_orders,
                'po_type' => $po_type,
                'currency' => $currency,
            ]);
        }
        catch (Exception $e) {
            info($e);
            return response()->json('Error occured in the loading page', 400);
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
        //info($request);
        try {
            PurchaseOrder::create($request->only(PurchaseOrder::REQUEST_INPUTS));
             $po_no= PurchaseOrder::max('po_no');
             for ($i = 0; $i < count($request['item_no']); $i++) {
                 PurchaseOrderItem::create([
                    'po_no'=>$po_no,
                     'item_no' => $request['item_no'][$i],
                     'qty' => $request['qty'][$i],
                     'rate_per_qty' => $request['rate_per_qty'][$i],
                     'discount' => $request['discount'][$i],
                    //  'previous_rate' => $request['previous_rate'][$i],
                     'item_amount' => $request['item_amount'][$i],
                     'pending_qty' => $request['pending_qty'][$i],
                 ]);
             }
             info($request);
            return response()->json('Purchase Created Successfully', 200);

        } catch (Exception $e) {
            info($e);
            return response()->json('Error occured in the store', 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */

    public function show($po_no)
{
    info($po_no);
    try {
        $purchase_orders =  DB::table('purchase_order')
        ->join('supplier_masters', 'purchase_order.supplier_no', '=', 'supplier_masters.supplier_no')
       ->join('project_masters', 'purchase_order.delivery_location', '=', 'project_masters.project_no')
       ->select( 'supplier_masters.*','project_masters.*', 'purchase_order.*',
       DB::raw('DATE(purchase_order.quote_date) as quote_date'),
       DB::raw('DATE(purchase_order.po_date) as po_date'),
       DB::raw('DATE(purchase_order.credit_period) as credit_period'))
       ->where('purchase_order.po_no', $po_no)
       ->get();
           $purchase_orders_item = DB::table('purchase_order_item')
           ->join('item_masters', 'purchase_order_item.item_no', '=', 'item_masters.id')
           ->join('item_supplier', 'item_masters.id', '=', 'item_supplier.item_no')
           ->join('purchase_order', 'purchase_order_item.po_no', '=', 'purchase_order.po_no')
            ->select('purchase_order_item.*', 'item_masters.*','item_supplier.*',)
            ->where('purchase_order_item.po_no', $po_no)
            ->get();
info($purchase_orders_item);
        return response()->json([
            'purchase_orders' => $purchase_orders,
            'purchase_orders_item'=>$purchase_orders_item,
        ]);
    } catch (Exception $e) {
        info($e);
        return response()->json('Error occurred in the show', 400);
    }
}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */

     public function update(Request $request, $po_no)
     {
         try {
              $purchase_orders = PurchaseOrder::where('po_no', $po_no)->first();
              $purchase_orders->update($request->only(PurchaseOrder::REQUEST_INPUTS));
             // update the data

            $po_delete=PurchaseOrderItem::where('po_no',$po_no)->delete();
            for ($i = 0;$i <  count($request['item_no']); $i++) {
                // info(count($request['item_no']));
                PurchaseOrderItem::create([
                    'po_no'=>$po_no,
                    'item_no' => $request['item_no'][$i],
                    'qty' => $request['qty'][$i],
                    'rate_per_qty' => $request['rate_per_qty'][$i],
                    'discount' => $request['discount'][$i],
                    // 'previous_rate' => $request['previous_rate'][$i],
                    'item_amount' => $request['item_amount'][$i],
                    'pending_qty' => $request['pending_qty'][$i],
                ]);
         }
             return response()->json('Purchase Order updated successfully', 200);
         } catch (Exception $e) {
             info($e);
             return response()->json('Error occurred while updating Purchase', 400);
         }

     }

    /**
     * Remove the specified  resource from storage.
     *
     * @param  \App\Models\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy($po_no){
        try {
            // Disable foreign key check
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            $purchase_orders = PurchaseOrder::where('po_no', $po_no)->first();

            if ($purchase_orders != null) {
                $purchase_order_items = PurchaseOrderItem::where('po_item_no', $po_no)->get();

                foreach ($purchase_order_items as $purchase_order_item) {
                    $purchase_order_item->delete();
                }

                $purchase_orders->delete();

                // Enable foreign key check
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');

                return response()->json('PurchaseOrder Deleted Successfully', 200);
            } else {
                // Enable foreign key check
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');

                return response()->json('PurchaseOrder not found', 404);
            }
        } catch (Exception $e) {
            // Enable foreign key check
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            info($e);
            return response()->json('Error occurred in the delete', 400);
        }
    }

}