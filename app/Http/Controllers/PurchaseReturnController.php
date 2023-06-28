<?php

namespace App\Http\Controllers;

use App\Models\ItemMaster;
use App\Models\ItemSupplier;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnItem;
use App\Models\GoodsReceivingNote;
use App\Models\GoodsReceivedNoteItem;
use App\Models\PurchaseOrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
require_once(app_path('constants.php'));

class PurchaseReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function grn_no()
    {
        $grn_code = $_GET['grn_code'];
        $data = GoodsReceivingNote::where('grn_code','LIKE',$grn_code.'%')
        ->where('deleted','=', '0')
        ->get();
        if ($data) 
        {
            $data = $data->toArray();

            // Convert the data to UTF-8 encoding
            array_walk_recursive($data, function (&$value) {
                if (is_object($value)) {
                    $value = (array) $value; // Convert the stdClass object to an array
                }

                if (is_array($value)) {
                    array_walk_recursive($value, function (&$item) {
                        if (!mb_check_encoding($item, 'UTF-8')) {
                            // Handle invalid characters
                            $item = mb_convert_encoding($item, 'UTF-8', 'UTF-8');
                        }
                    });
                } else {
                    if (!mb_check_encoding($value, 'UTF-8')) {
                        // Handle invalid characters
                        $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                    }
                }
            });
        }
        return $data;
    }

    public function get_grn_details()
    {
        try {
            $grn_code = $_GET['grn_code'];


            $grn_info = DB::table('goods_received_note')
                ->join('supplier_masters', 'goods_received_note.supplier_no', '=', 'supplier_masters.supplier_no')
                ->join('project_masters', 'goods_received_note.project_no', '=', 'project_masters.project_no')
                ->select('goods_received_note.grn_no', 'goods_received_note.grn_date', 'goods_received_note.supplier_no', 'supplier_masters.name',
                    'goods_received_note.project_no', 'project_masters.project_name', 'project_masters.project_code','goods_received_note.grn_purchase_type',
                    'goods_received_note.vat', DB::raw('DATE(goods_received_note.grn_date) as grn_date'))
                ->where('goods_received_note.grn_code', $grn_code)
                ->first();

            if ($grn_info)
            {
               $grn_no = $grn_info->grn_no;
               $grn_date = $grn_info->grn_date;
               $supplier_no = $grn_info->supplier_no;
               $name = $grn_info->name;
               $project_no = $grn_info->project_no;
               $project_name = $grn_info->project_name;
               $project_code = $grn_info->project_code;
               $grn_purchase_type=$grn_info->grn_purchase_type;
               $vat = $grn_info->vat;

               //get grn items details

               $grn_items = DB::table('goods_received_note_item')
                   ->join('item_masters', 'goods_received_note_item.item_no', '=', 'item_masters.id')
                   ->select('goods_received_note_item.*', 'item_masters.item_name','item_masters.item_unit')
                   ->where('grn_no', $grn_no)
                   ->get();

               return response()->json([
                   'grn_code' => $grn_code,
                   'grn_info' => $grn_info,
                   'grn_items' => $grn_items,
                   'grn_no' => $grn_no,
                   'grn_date'=>$grn_date,
                   'supplier_no'=> $supplier_no,
                   'name'=> $name,
                   'project_no'=> $project_no,
                   'project_name'=> $project_name,
                   'project_code'=> $project_code,
                   'grn_purchase_type'=>$grn_purchase_type,
                   'vat'=>$vat
               ]);
           } else {
               return response()->json('GRN not found', 404);
           }
        } catch (Exception $e) {
            info($e);
            return response()->json('Error occurred in the get GRN details', 400);
        }
    }

    public function index(Request $request)
    {
        try
        {
            if ($request->session()->has('user'))
            {
                $currency = CURRENCY;
                //$grn_purchase_type = PROJECTORDERTYPE;
                //$pr = PurchaseReturn::all();
                $item=ItemMaster::all();
                $item_name=$item->pluck('item_name');
                $good =GoodsReceivingNote::all();
                $grn = $good->pluck('grn_code');

                $pr = PurchaseReturn::join('project_masters', 'purchase_return.project_no', '=', 'project_masters.project_no')
                ->join('supplier_masters', 'purchase_return.supplier_no', '=', 'supplier_masters.supplier_no')
                ->join('goods_received_note', 'purchase_return.grn_no', '=', 'goods_received_note.grn_no')
                ->select('purchase_return.*', 'project_masters.*', 'supplier_masters.*','goods_received_note.*',
                DB::raw('DATE(goods_received_note.grn_date) as grn_date'))
                ->where('purchase_return.deleted','0')
                ->get();


            return view('purchasereturn.index')->with([
                //'grn_purchase_type'=>$grn_purchase_type,
                'currency' => $currency,
                'prs' => $pr,
                'grn'  => $grn,
                'item_name'=>$item_name
            ]);
        }
        else
        {
            return redirect("/");
        }
        }
        catch (Exception $e)
        {
            info($e);
            return response()->json('Error occured in the Purchase return index', 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $grn_no=$request['grn_no'];
        $purchase_type=$request['pr_purchase_type'];

        try
        {

            $purchase = PurchaseReturn::create($request->only(PurchaseReturn::REQUEST_INPUTS));

            $pr= PurchaseReturn::max('pr_no');
            // supplier_no
            $supplier_no=$request['supplier_no'];
            // count of item_no
            $itemCount = count($request['item_no']);
            $po_no = GoodsReceivingNote::select('po_no')
            ->where('grn_no', $grn_no)
            ->value('po_no');
            //info($po_no);
            for ($i = 0; $i < $itemCount; $i++)
            {
                $item_no=$request['item_no'][$i];
              //  info($item_no);
                $pending_qty = GoodsReceivedNoteItem::select('pending_qty')
                ->where('grn_no', $grn_no)
                ->where('item_no', $item_no)
                ->value('pending_qty');
                // info($pending_qty);

                $update_pending_qty=$pending_qty+$request['return_qty'][$i];
                // info($update_pending_qty);

                // update pending qty in grn
                GoodsReceivedNoteItem::where('grn_no',$grn_no)->where('item_no',$item_no)->update(['pending_qty'=> $update_pending_qty]);

                // update pending qty in po
                PurchaseOrderItem::where('po_no',$po_no)->where('item_no',$item_no)->update(['pending_qty' => $update_pending_qty]);
                if($purchase_type =="Local Purchase Order" || $purchase_type =="Cash Purchase")
                {
                    //update in itemmaster table
                    $item_update = ItemMaster::where('id',$item_no)->value('total_quantity');
                    $total_qty =  $item_update - $request['return_qty'][$i];
                    ItemMaster::where('id',$item_no)->update(['total_quantity' => $total_qty]);
                    info( $item_update);
                    info($total_qty);
                    //update in itemsupplier table
                    $item_supplier = ItemSupplier::where('supplier_no',$supplier_no)->where('item_no',$item_no)->value('quantity');
                    $update_qty = $item_supplier - $request['return_qty'][$i];
                    ItemSupplier::where('item_no',$item_no)->update(['quantity'=>$update_qty]);
                    info($item_supplier);
                    info($update_qty);
                }
                PurchaseReturnItem::create([
                    'pr_no'=>$pr,
                    'item_no' => $request['item_no'][$i],
                    'pack_specification' => $request['pack_specification'][$i],
                    'quantity' => $request['quantity'][$i],
                    'receiving_qty' => $request['receiving_qty'][$i],
                    'return_qty' => $request['return_qty'][$i],
                    'rate_per_qty'=>$request['rate_per_qty'][$i],
                    'item_amount'=>$request['item_amount'][$i]
                ]);

                $closing_bal_check=DB::table('accounts_payables')
                ->where('supplier_no', $supplier_no)
                ->max('ap_no');
                if($closing_bal_check !="")
                {
                    $closing_bal_add=DB::table('accounts_payables')
                    ->where('ap_no',  $closing_bal_check)
                    ->value('closing_balance');
                    $closing_bal=$closing_bal_add-$request['return_amount'];
                    DB::table('accounts_payables')
                    ->where('ap_no',  $closing_bal_check)
                    ->update(['closing_balance' => $closing_bal]);
                }
                //info($purchase);
            }
            return response()->json('Purchase return Created Successfully', 200);
        }
        catch (Exception $e)
        {
            info($e);
            return response()->json('Error occured in the Purchase return store', 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PurchaseReturn  $purchaseReturn
     * @return \Illuminate\Http\Response
     */
    public function show($purchaseReturn)
    {
        try
        {
        DB::beginTransaction();
        $pr = PurchaseReturn::join('project_masters', 'purchase_return.project_no', '=', 'project_masters.project_no')
        ->join('supplier_masters', 'purchase_return.supplier_no', '=', 'supplier_masters.supplier_no')
        ->join('goods_received_note', 'purchase_return.grn_no', '=', 'goods_received_note.grn_no')
        ->select('purchase_return.*', 'project_masters.*', 'supplier_masters.*','goods_received_note.grn_no','goods_received_note.grn_code',
        'goods_received_note.grn_purchase_type',DB::raw('DATE(goods_received_note.grn_date) as grn_date'),DB::raw('DATE(purchase_return.date) as date'))
        ->where('purchase_return.pr_no', $purchaseReturn)
        ->get();
        $pr_item=PurchaseReturnItem::join('item_masters', 'purchase_return_item.item_no', '=', 'item_masters.id')
        ->select( 'purchase_return_item.*', 'item_masters.*')
        ->where('purchase_return_item.pr_no', $purchaseReturn)
        ->get();

        DB::commit();
        return response()->json([
            'pr' => $pr,
            'pr_item'=>$pr_item

        ]);
    }
    catch (Exception $e) {
        DB::rollBack();
        info($e);
        return response()->json('Error occured in the Purchase return show', 400);
    }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PurchaseReturn  $purchaseReturn
     * @return \Illuminate\Http\Response
     */
     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PurchaseReturn  $purchaseReturn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $pr_no)
    {
    $grn_no = $request['grn_no'];
    $purchase_type = $request['pr_purchase_type'];

    try {
        DB::beginTransaction();

        $pr = PurchaseReturn::where('pr_no', $pr_no)->first();
        $supplier_no = $request['supplier_no'];

        $return_amount = $pr->return_amount;
        if ($request['return_amount'] != $return_amount) {
            $return_amt = $request['return_amount'] - $return_amount;

            $closing_bal_check = DB::table('accounts_payables')
                ->where('supplier_no', $supplier_no)
                ->max('ap_no');

            if ($closing_bal_check != "") {
                $closing_bal_add = DB::table('accounts_payables')
                    ->where('ap_no', $closing_bal_check)
                    ->value('closing_balance');

                $closing_bal = $closing_bal_add + $return_amt;

                DB::table('accounts_payables')
                    ->where('ap_no', $closing_bal_check)
                    ->update(['closing_balance' => $closing_bal]);
            }
        }

        $pr->update($request->only(PurchaseReturn::REQUEST_INPUTS));

        $itemCount = count($request['item_no']);

        $po_no = GoodsReceivingNote::select('po_no')
            ->where('grn_no', $grn_no)
            ->value('po_no');

        for ($i = 0; $i < $itemCount; $i++) {
            $item_no = $request['item_no'][$i];

            if ($purchase_type == "Local Purchase Order" || $purchase_type == "Cash Purchase") {
                // Update in itemmaster table
                $item_update = ItemMaster::where('id', $item_no)->value('total_quantity');
                $return_qty = $request['return_qty'][$i];
                $original_return_qty = PurchaseReturnItem::where('pr_no', $pr_no)->where('item_no', $item_no)->value('return_qty');
                $original_qty = $original_return_qty - $return_qty;
                $total_qty = $item_update - $original_qty;
                ItemMaster::where('id', $item_no)->update(['total_quantity' => $total_qty]);

                // Update in itemsupplier table
                $item_supplier = ItemSupplier::where('supplier_no', $supplier_no)->where('item_no', $item_no)->value('quantity');
                $original_qty1 = $original_return_qty - $return_qty;
                $update_qty = $item_supplier - $original_qty1;
                ItemSupplier::where('item_no', $item_no)->update(['quantity' => $update_qty]);
            }

            $pending_qty = GoodsReceivedNoteItem::select('pending_qty')
                ->where('grn_no', $grn_no)
                ->where('item_no', $item_no)
                ->value('pending_qty');

            $return_qty1 = $request['return_qty'][$i];
            $original_return_qty1 = PurchaseReturnItem::where('pr_no', $pr_no)->where('item_no', $item_no)->value('return_qty');
            $original_qty2 = $original_return_qty1 - $return_qty1;
            $update_pending_qty = $pending_qty - $original_qty2;

            // update pending qty in grn
            GoodsReceivedNoteItem::where('grn_no', $grn_no)->where('item_no', $item_no)->update(['pending_qty' => $update_pending_qty]);

            // update pending qty in po
            PurchaseOrderItem::where('po_no', $po_no)->where('item_no', $item_no)->update(['pending_qty' => $update_pending_qty]);

            // Delete existing PurchaseReturnItem records
            PurchaseReturnItem::where('pr_no', $pr_no)->delete();

            PurchaseReturnItem::create([
                'pr_no' => $pr_no,
                'item_no' => $request['item_no'][$i],
                'pack_specification' => $request['pack_specification'][$i],
                'quantity' => $request['quantity'][$i],
                'receiving_qty' => $request['receiving_qty'][$i],
                'return_qty' => $request['return_qty'][$i],
                'rate_per_qty' => $request['rate_per_qty'][$i],
                'item_amount' => $request['item_amount'][$i]
            ]);
        }

        DB::commit();
        return response()->json('Purchase Return updated successfully', 200);
    } catch (Exception $e) {
        DB::rollBack();
        info($e);
        return response()->json('Error occurred in the purchase return update', 400);
    }
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PurchaseReturn  $purchaseReturn
     * @return \Illuminate\Http\Response
     */
    public function delete($pr_no)

    {
       info($pr_no);
       try {
        $grn_item = PurchaseReturn::where('pr_no', $pr_no)->update(['deleted' => 1]);
        $grn = PurchaseReturnItem::where('pr_no', $pr_no)->update(['deleted' => 1]);
        return response()->json('Purchase Return Deleted Successfully', 200);
    } catch (Exception $e) {
        info($e);
        return response()->json('Error occured in the delete', 400);
    }
    }
}