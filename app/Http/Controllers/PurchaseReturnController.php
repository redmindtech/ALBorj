<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseReturnRequest;
use App\Models\ItemMaster;
use App\Models\ItemSupplier;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnItem;
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
    public function index()
    {
        try{
        $purchase_type = GRNPURCHASETYPE;
        $currency = CURRENCY;
        $pr = PurchaseReturn::join('project_masters', 'purchase_return.project_no', '=', 'project_masters.project_no')
        ->join('supplier_masters', 'purchase_return.supplier_no', '=', 'supplier_masters.supplier_no')
        ->select('purchase_return.*', 'project_masters.*', 'supplier_masters.*' ) 
        ->where('deleted','0')
        ->get();
      
        return view('purchasereturn.index')->with([
            'purchase_type' => $purchase_type,
            'currency' => $currency,
            'prs' => $pr,
        ]);
    }
    catch (Exception $e) {
        info($e);
        return response()->json('Error occured in the Purchase return index', 400);
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
    public function store(PurchaseReturnRequest $request)
    {
        try{
        PurchaseReturn::create($request->only(PurchaseReturn::REQUEST_INPUTS));
        $pr= PurchaseReturn::max('pr_no');
        $itemCount = count($request['item_no']);
        $supplier_no=$request['supplier_no'];
        for ($i = 0; $i < $itemCount; $i++)
        {       
           $item_no= $request['item_no'][$i];
           info($item_no);
            $item_update = ItemMaster::where('id', $item_no)->value('total_quantity'); 
            info($item_update);
            info( $request['item_return_quantity'][$i]);
            $item_qty=$item_update - $request['item_return_quantity'][$i];    

           
            ItemMaster::where('id', $item_no)
            ->update(['total_quantity' => $item_qty]);

            $item_supplier_check = ItemSupplier::where('item_no', $item_no)
                ->where('supplier_no', $supplier_no)->value('quantity');                        
                $item_supplier_qty=$item_supplier_check - $request['item_return_quantity'][$i]; 

                // update itemsupplier quantity and rate per qty
                $item_supplier_check = ItemSupplier::where('item_no', $item_no)
                ->where('supplier_no', $supplier_no)->update(['quantity' => $item_supplier_qty,
                 'price_per_qty'=>$request['rate_per_qty'][$i]
            ]);   

        PurchaseReturnItem::create([
            'pr_no'=>$pr, 
            'item_no' => $request['item_no'][$i],
            'item_return_quantity' => $request['item_return_quantity'][$i],
            'rate_per_qty'=>$request['rate_per_qty'][$i],
            'item_return_total'=>$request['item_return_total'][$i],
            'vat'=>$request['vat'][$i]
            ]); 
            // update closing bal in accounts_payables
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
        }
        return response()->json('Purchase return Details Created Successfully', 200);
    }
    catch (Exception $e) {
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
    { try{
        DB::beginTransaction();
        $pr = PurchaseReturn::join('project_masters', 'purchase_return.project_no', '=', 'project_masters.project_no')
        ->join('supplier_masters', 'purchase_return.supplier_no', '=', 'supplier_masters.supplier_no')
        ->select('purchase_return.*', 'project_masters.*', 'supplier_masters.*' ) 
        ->where('purchase_return.pr_no', $purchaseReturn)
        ->get();
        $pr_item=PurchaseReturnItem::     
        join('item_masters', 'purchase_return_item.item_no', '=', 'item_masters.id') 
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
    public function edit(PurchaseReturn $purchaseReturn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PurchaseReturn  $purchaseReturn
     * @return \Illuminate\Http\Response
     */
    public function update(PurchaseReturnRequest $request,$pr_no)
    {
        try{
            DB::beginTransaction();
        info($pr_no);
        $pr = PurchaseReturn::where('pr_no', $pr_no)->first();
        $pr->update($request->only(PurchaseReturn::REQUEST_INPUTS));
        $itemCount = count($request['item_no']);      
        $pr_delete=PurchaseReturnItem::where('pr_no',$pr_no)->delete();
        for ($i = 0; $i < $itemCount; $i++) {                
            PurchaseReturnItem::create([
                'pr_no'=>$pr_no, 
                'item_no' => $request['item_no'][$i],
                'item_return_quantity' => $request['item_return_quantity'][$i],
                'rate_per_qty'=>$request['rate_per_qty'][$i],
                'item_return_total'=>$request['item_return_total'][$i],
                'vat'=>$request['vat'][$i]
     ]);
    }
    DB::commit();
        return response()->json('Purchase Return Details updated successfully', 200);
}
        catch (Exception $e) {
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
        return response()->json('Purchase Return Details Deleted Successfully', 200);
    } catch (Exception $e) {
        info($e);
        return response()->json('Error occured in the delete', 400);
    }
    }
}