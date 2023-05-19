<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\SupplierMaster;
use App\Models\ProjectMaster;
use App\Models\ItemMaster;
use App\Models\ItemSupplier;
use App\Models\EmployeeMaster;
use App\Models\MaterialRequisition;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Http\Requests\PurchaseOrderRequest;
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
    public function  getmrdata()
    {
          info("hii");
        try
        {
            $mrcode = $_GET['mrcode'];


            $mr_no=DB::table('materials')
             ->select('mr_id')
             ->where('materials.mr_reference_code', $mrcode)
            ->value('mr_id');
            $mr_items = DB::table('material_requisition_item')
            ->join('item_masters', 'material_requisition_item.item_no', '=', 'item_masters.id')
            ->select('material_requisition_item.*', 'item_masters.*')
            ->where('material_requisition_item.mr_no', $mr_no)
            ->get();
            $mr_data=DB::table('materials')
            ->select('*')
            ->where('mr_id',$mr_no)
            ->get();
            info($mr_data);

            //  $data = GoodsReceivingNote::where('grn_code','LIKE',$grncode.'%')->get();
            return response()->json([
                'mr_no' => $mr_no,
                'mr_items' => $mr_items,
                'mr_data'=>$mr_data

            ]);
            // info($data);

            // return $data;
        }
        catch (Exception $e)
        {
            info($e);
            return response()->json('Error occured in the get mr details', 400);
        }
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
           ->where('purchase_order.deleted','0')
           ->get();
         info($purchase_orders);

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
    public function store(PurchaseOrderRequest $request)
    {
        // info($request);
        $file = $request->file('attachments');
        try {
            // grn insert data
            $purchase_orders = new PurchaseOrder($request->only(PurchaseOrder::REQUEST_INPUTS));
                if ($file) {
                    $fileData = file_get_contents($file->getRealPath());
                    $fileName = $file->getClientOriginalName();
          // Save the file data as a BLOB in the database
                    $purchase_orders->attachments = $fileData;
                    $purchase_orders->filename = $fileName;
                }
         // Save the GoodsReceivingNote instance
                $purchase_orders->save();
                $po_no= PurchaseOrder::max('po_no');
        // po insert data

             $po_no= PurchaseOrder::max('po_no');
             for ($i = 0; $i < count($request['item_no']); $i++) {
                 PurchaseOrderItem::create([
                    'po_no'=>$po_no,
                     'item_no' => $request['item_no'][$i],
                     'qty' => $request['qty'][$i],
                     'rate_per_qty' => $request['rate_per_qty'][$i],
                     'discount' => $request['discount'][$i],
                     'item_amount' => $request['item_amount'][$i],
                    //  'pending_qty' => $request['pending_qty'][$i],
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
         
         try {
            $purchase_order =  DB::table('purchase_order')->select('mr_no')->where('purchase_order.po_no', $po_no)->value('mr_no');

             if ($purchase_order != '') {
                 $purchase_orders = DB::table('purchase_order')
                     ->join('supplier_masters', 'purchase_order.supplier_no', '=', 'supplier_masters.supplier_no')
                     ->join('project_masters', 'purchase_order.delivery_location', '=', 'project_masters.project_no')
                     ->join('employee_masters', 'purchase_order.po_prepared', '=', 'employee_masters.id')
                     ->join('materials', 'purchase_order.mr_no', '=', 'materials.mr_id')
                     ->select('supplier_masters.*', 'project_masters.*', 'purchase_order.*', 'employee_masters.*', 'materials.*',
                         DB::raw('DATE(purchase_order.quote_date) as quote_date'),
                         DB::raw('DATE(purchase_order.po_date) as po_date'),
                         DB::raw('DATE(purchase_order.credit_period) as credit_period'),
                         'purchase_order.filename')
                     ->where('purchase_order.po_no', $po_no)
                     ->get();

             } else {
                 $purchase_orders = DB::table('purchase_order')
                     ->join('supplier_masters', 'purchase_order.supplier_no', '=', 'supplier_masters.supplier_no')
                     ->join('project_masters', 'purchase_order.delivery_location', '=', 'project_masters.project_no')
                     ->join('employee_masters', 'purchase_order.po_prepared', '=', 'employee_masters.id')
                     ->select('supplier_masters.*', 'project_masters.*', 'purchase_order.*', 'employee_masters.*',
                         DB::raw('DATE(purchase_order.quote_date) as quote_date'),
                         DB::raw('DATE(purchase_order.po_date) as po_date'),
                         DB::raw('DATE(purchase_order.credit_period) as credit_period'))
                     ->where('purchase_order.po_no', $po_no)
                     ->get();

             }

             if ($purchase_orders) {
                $purchase_orders = $purchase_orders->toArray();

                // Convert the data to UTF-8 encoding
                array_walk_recursive($purchase_orders, function (&$value) {
                    if (is_object($value)) {
                        $value = (array) $value; // Convert the stdClass object to an array
                    }

                    if (is_array($value)) {
                        array_walk_recursive($value, function (&$item) {
                            $item = mb_convert_encoding($item, 'UTF-8', 'UTF-8');
                        });
                    } else {
                        $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                    }
                });
            }




             $purchase_orders_item = DB::table('purchase_order_item')
                 ->join('item_masters', 'purchase_order_item.item_no', '=', 'item_masters.id')
                 ->join('item_supplier', 'item_masters.id', '=', 'item_supplier.item_no')
                 ->join('purchase_order', 'purchase_order_item.po_no', '=', 'purchase_order.po_no')
                 ->select('purchase_order_item.*', 'item_masters.*', 'item_supplier.*')
                 ->where('purchase_order_item.po_no', $po_no)
                 ->get();

             return response()->json([
                 'purchase_orders' => $purchase_orders,
                 'purchase_orders_item' => $purchase_orders_item,
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

     public function update(PurchaseOrderRequest $request, $po_no)
     {
         try {
              $purchase_orders = PurchaseOrder::where('po_no', $po_no)->first();
              $purchase_orders->update($request->only(PurchaseOrder::REQUEST_INPUTS));
               // Check if the delete button was clicked and delete the attachments
            if ($request->has('delete_attachment') && $request->input('delete_attachment') === '1') {
                $purchase_orders->attachments = null;
                $purchase_orders->filename = null;
                $purchase_orders->save();
            }

            // Update the attachments if a new file is uploaded
            $file = $request->file('attachments');
            if ($file) {
                $fileData = file_get_contents($file->getRealPath());
                $fileName = $file->getClientOriginalName();

                $purchase_orders->attachments = $fileData;
                $purchase_orders->filename = $fileName;
                $purchase_orders->save();
            }
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
                    // 'pending_qty' => $request['pending_qty'][$i],
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
