<?php

namespace App\Http\Controllers;

use App\Http\Requests\GoodReceivingNoteRequest;
use App\Models\GoodsReceivingNote;
use App\Models\GoodsReceivedNoteItem;
use App\Models\ItemMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
require_once(app_path('constants.php'));
class GoodsReceivingNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $purchase_type=GRNPURCHASETYPE;
             $grn = GoodsReceivingNote::join('project_masters', 'goods_received_note.project_no', '=', 'project_masters.project_no')
             ->join('supplier_masters', 'goods_received_note.supplier_no', '=', 'supplier_masters.supplier_no')                 
             ->select('goods_received_note.*', 'project_masters.*', 'supplier_masters.*',
             DB::raw('DATE(goods_received_note.grn_date) as grn_date'),
             DB::raw('DATE(goods_received_note.po_date) as po_date'),
             DB::raw('DATE(goods_received_note.due_Date) as due_Date'))  
             ->where('deleted','0')          
             ->get();
            return view('goodsreceivingnote.index')
            ->with([
                'purchase_type' => $purchase_type,
                'grns'=>$grn
             ]);
        }
        catch (Exception $e) {
            info($e);
            return redirect()->route("goodsreceivingnote.index")->with([
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
    public function store(GoodReceivingNoteRequest $request)
    {  
        try {
                GoodsReceivingNote::create($request->only(GoodsReceivingNote::REQUEST_INPUTS));         
                $grn= GoodsReceivingNote::max('grn_no');
                $itemCount = count($request['item_no']);
                for ($i = 0; $i < $itemCount; $i++) {
                GoodsReceivedNoteItem::create([
                'grn_no'=>$grn, 
                'item_no' => $request['item_no'][$i],
                'pack_specification' => $request['pack_specification'][$i],
                'quantity' => $request['quantity'][$i],
                'rate_per_qty' => $request['rate_per_qty'][$i],
                'receiving_qty' => $request['receiving_qty'][$i],
                'item_amount' => $request['item_amount'][$i],
                ]);               
             }              
                return response()->json('Grn Created Successfully', 200);
           } catch (Exception $e) {
                info($e);
                return response()->json('Error occured in the store', 400);
            }

    }

   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GoodsReceivingNote  $goodsReceivingNote
     * @return \Illuminate\Http\Response
     */
    public function show($grn_no)
    {        
      try {
        $po_no_check=GoodsReceivingNote::select('po_no') ->where('grn_no', $grn_no)->value('po_no');
       
        // check po_no
        if ($po_no_check ==""){
            
            $grn = GoodsReceivingNote::join('project_masters', 'goods_received_note.project_no', '=', 'project_masters.project_no')
            ->join('supplier_masters', 'goods_received_note.supplier_no', '=', 'supplier_masters.supplier_no')               
            ->select('goods_received_note.*', 'project_masters.*', 'supplier_masters.*',
            DB::raw('DATE(goods_received_note.grn_date) as grn_date'),
            DB::raw('DATE(goods_received_note.po_date) as po_date'),
            DB::raw('DATE(goods_received_note.due_Date) as due_Date'))
            ->where('goods_received_note.grn_no', $grn_no)
            ->get(); 
        }
        else{           
        
            $grn = GoodsReceivingNote::join('project_masters', 'goods_received_note.project_no', '=', 'project_masters.project_no')
            ->join('supplier_masters', 'goods_received_note.supplier_no', '=', 'supplier_masters.supplier_no')
            ->join('purchase_order','goods_received_note.po_no','=','purchase_order.po_no')      
            ->select('goods_received_note.*', 'project_masters.*', 'supplier_masters.*','purchase_order.po_code',
            DB::raw('DATE(goods_received_note.grn_date) as grn_date'),
            DB::raw('DATE(goods_received_note.po_date) as po_date'),
            DB::raw('DATE(goods_received_note.due_Date) as due_Date'))
            ->where('goods_received_note.grn_no', $grn_no)
            ->get();
        }
            $grn_item=GoodsReceivedNoteItem::     
            join('item_masters', 'goods_received_note_item.item_no', '=', 'item_masters.id')
            ->select( 'goods_received_note_item.*', 'item_masters.*')
            ->where('goods_received_note_item.grn_no', $grn_no)
            ->get();    
             return response()->json([
                'grn' => $grn,
                'grn_item' => $grn_item
            ]);
        } catch (Exception $e) {
            info($e);
            return response()->json('Error occured in the show', 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GoodsReceivingNote  $goodsReceivingNote
     * @return \Illuminate\Http\Response
     */
    public function update(GoodReceivingNoteRequest $request, $grn_no)
    {       
        try {
             $grn = GoodsReceivingNote::where('grn_no', $grn_no)->first();
             $grn->update($request->only(GoodsReceivingNote::REQUEST_INPUTS));          
            // update the GRN item data
            $itemCount = count($request['item_no']);      
           $grn_delete=GoodsReceivedNoteItem::where('grn_no',$grn_no)->delete();
           for ($i = 0; $i < $itemCount; $i++) {                
            GoodsReceivedNoteItem::create([
            'grn_no'=>$grn_no, 
            'item_no' => $request['item_no'][$i],
            'pack_specification' => $request['pack_specification'][$i],
            'quantity' => $request['quantity'][$i],
            'rate_per_qty' => $request['rate_per_qty'][$i],
            'receiving_qty' => $request['receiving_qty'][$i],
            'item_amount' => $request['item_amount'][$i],
        ]);
        }          
            return response()->json('GRN updated successfully', 200);
        } catch (Exception $e) {
            info($e);
            return response()->json('Error occurred while updating GRN', 400);
        }
        
    }
// DELETE FUNCTION
   public function delete($grn_no){
         try {
            $grn_item = GoodsReceivedNoteItem::where('grn_no', $grn_no)->update(['deleted' => 1]);
            $grn = GoodsReceivingNote::where('grn_no', $grn_no)->update(['deleted' => 1]);
            return response()->json('GRN Deleted Successfully', 200);
        } catch (Exception $e) {
            info($e);
            return response()->json('Error occured in the delete', 400);
        }
    } 
  
}

