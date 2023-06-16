<?php

namespace App\Http\Controllers;

use App\Models\ItemMaster;
use App\Models\ItemSupplier;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnItem;
use App\Models\GoodsReceivingNote;
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

    public function get_grn_details()
    {
        try {
            $grn_code = $_GET['grn_code'];
            info($grn_code);

            $grn_info = DB::table('goods_received_note')
                ->join('supplier_masters', 'goods_received_note.supplier_no', '=', 'supplier_masters.supplier_no')
                ->join('project_masters', 'goods_received_note.project_no', '=', 'project_masters.project_no')
                ->select('goods_received_note.grn_no', 'goods_received_note.grn_date', 'goods_received_note.supplier_no', 'supplier_masters.name',
                    'goods_received_note.project_no', 'project_masters.project_name', 'project_masters.project_code','goods_received_note.grn_purchase_type')
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

               //get grn items details

               $grn_items = DB::table('goods_received_note_item')
                   ->join('item_masters', 'goods_received_note_item.item_no', '=', 'item_masters.id')
                   ->select('goods_received_note_item.*', 'item_masters.item_name')
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
                   'grn_purchase_type'=>$grn_purchase_type
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
            if ($request->session()->has('user')) {
            $currency = CURRENCY;
            $grn_purchase_type = PROJECTORDERTYPE;
            //$pr = PurchaseReturn::all();

            $pr = PurchaseReturn::join('project_masters', 'purchase_return.project_no', '=', 'project_masters.project_no')
            ->join('supplier_masters', 'purchase_return.supplier_no', '=', 'supplier_masters.supplier_no')
            ->join('goods_received_note', 'purchase_return.grn_no', '=', 'goods_received_note.grn_no')
            ->select('purchase_return.*', 'project_masters.*', 'supplier_masters.*','goods_received_note.*',
            DB::raw('DATE(goods_received_note.grn_date) as grn_date'))
            ->where('purchase_return.deleted','0')
            ->get();


            return view('purchasereturn.index')->with([
                'grn_purchase_type'=>$grn_purchase_type,
                'currency' => $currency,
                'prs' => $pr,
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
        try
        {
            $purchase = PurchaseReturn::create($request->only(PurchaseReturn::REQUEST_INPUTS));
            $pr= PurchaseReturn::max('pr_no');
            $itemCount = count($request['item_no']);

            for ($i = 0; $i < $itemCount; $i++)
            {
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

                info($purchase);
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
        ->select('purchase_return.*', 'project_masters.*', 'supplier_masters.*','goods_received_note.*',
                DB::raw('DATE(goods_received_note.grn_date) as grn_date'),DB::raw('DATE(purchase_return.date) as date'))
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
    public function update(Request $request,$pr_no)
    {
        try
        {
            DB::beginTransaction();
            info($pr_no);
            $pr = PurchaseReturn::where('pr_no', $pr_no)->first();
            $pr->update($request->only(PurchaseReturn::REQUEST_INPUTS));
            $itemCount = count($request['item_no']);
            $pr_delete=PurchaseReturnItem::where('pr_no',$pr_no)->delete();
            for ($i = 0; $i < $itemCount; $i++)
            {
                PurchaseReturnItem::create([
                    'pr_no'=>$pr_no,
                    'item_no' => $request['item_no'][$i],
                    'pack_specification' => $request['pack_specification'][$i],
                    'quantity' => $request['quantity'][$i],
                    'receiving_qty' => $request['receiving_qty'][$i],
                    'return_qty' => $request['return_qty'][$i],
                    'rate_per_qty'=>$request['rate_per_qty'][$i],
                    'item_amount'=>$request['item_amount'][$i]

                ]);
            }
            DB::commit();
            return response()->json('Purchase Return updated successfully', 200);
        }
        catch (Exception $e)
        {
            DB::rollBack();
            info($e);
            return response()->json('Error occured in the purchase return update', 400);
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