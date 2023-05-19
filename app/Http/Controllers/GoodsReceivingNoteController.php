<?php

namespace App\Http\Controllers;

use App\Http\Requests\GoodReceivingNoteRequest;
use App\Models\GoodsReceivingNote;
use App\Models\GoodsReceivedNoteItem;
use App\Models\ItemMaster;
use App\Models\ItemSupplier;
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
             ->where('goods_received_note.deleted','0')          
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
    //    for vat_typr
        if($request['vat_type']=="")
        {
            $request['vat_type']='0' ;
        }
        if($request['vat'] == "")
        {
            $request['vat_type']=null ; 
        }  
        $file = $request->file('attachments');        
        $po_no=$request['po_no'];
        try {
            // grn insert data
            $grn = new GoodsReceivingNote($request->only(GoodsReceivingNote::REQUEST_INPUTS));
                if ($file) {
                    $fileData = file_get_contents($file->getRealPath());
                    $fileName = $file->getClientOriginalName();
          // Save the file data as a BLOB in the database
                    $grn->attachments = $fileData;
                    $grn->filename = $fileName;
                } 
         // Save the GoodsReceivingNote instance
                $grn->save();        
                $grn= GoodsReceivingNote::max('grn_no');
         // supplier_no
                $supplier_no=$request['supplier_no'];
         // count of item_no
                $itemCount = count($request['item_no']);
         // iteration 
                for ($i = 0; $i < $itemCount; $i++)
            {                 
                 $item_no=$request['item_no'][$i];
         //  update total qty in itemmaster table
                $item_update = ItemMaster::where('id', $item_no)->value('total_quantity');                                     
                $item_qty=$item_update+ $request['receiving_qty'][$i];                     
                ItemMaster::where('id', $item_no)
                ->update(['total_quantity' => $item_qty]);
         // ITEM_SUPPLIER QUANTITY UPDATE OR CREATE NEW
                $item_supplier_check = ItemSupplier::where('item_no', $item_no)
                ->where('supplier_no', $supplier_no)->value('quantity');                        
                $item_supplier_qty=$item_supplier_check+$request['receiving_qty'][$i];               
                if($item_supplier_check == "")
                {                 
        //   create new record in itemsupplier
                    ItemSupplier::create([
                        'item_no' => $request['item_no'][$i],
                        'supplier_no'=> $supplier_no,
                        'quantity'=>$request['receiving_qty'][$i],
                        'price_per_qty'=>$request['rate_per_qty'][$i]
                    ]);
                }
                else{
        // update itemsupplier quantity and rate per qty
                      $item_supplier_check = ItemSupplier::where('item_no', $item_no)
                    ->where('supplier_no', $supplier_no)->update(['quantity' => $item_supplier_qty, 'price_per_qty'=>$request['rate_per_qty'][$i]
                ]);  
                }
        //UPDATE PO PENDING QUANTITY IN purchase_order_item
               $update_pending_qty= $request['pending_qty'][$i]-$request['receiving_qty'][$i];
               
                   
        // update po_status in purchase order table
                    if($update_pending_qty =='0')
                    {
                        $pendingQty = DB::table('purchase_order')
                        ->where('po_no',$po_no)
                        ->update(['po_status' => '1']);
                    }
                    else{
                        $pendingQty = DB::table('purchase_order')
                        ->where('po_no',$po_no)
                        ->update(['po_status' => '0']);
                    }
                    // end update po_status in purchase order table
               // data added in grn item table
                GoodsReceivedNoteItem::create([
                'grn_no'=>$grn, 
                'item_no' => $request['item_no'][$i],
                'pack_specification' => $request['pack_specification'][$i],
                'quantity' => $request['quantity'][$i],
                'rate_per_qty' => $request['rate_per_qty'][$i],
                'pending_qty' => $update_pending_qty,
                'item_amount' => $request['item_amount'][$i],
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
                    $closing_bal=$closing_bal_add+$request['gross_amount'];
                    DB::table('accounts_payables')
                    ->where('ap_no',  $closing_bal_check)
                    ->update(['closing_balance' => $closing_bal]); 
                 }  

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
    public function show($grn_no,$po_no )
    {
          try {
        
        $grn = GoodsReceivingNote::join('project_masters', 'goods_received_note.project_no', '=', 'project_masters.project_no')
        ->join('supplier_masters', 'goods_received_note.supplier_no', '=', 'supplier_masters.supplier_no')
        ->join('purchase_order', 'goods_received_note.po_no', '=', 'purchase_order.po_no')
        ->select('goods_received_note.*', 'project_masters.*', 'supplier_masters.*', 'purchase_order.po_code',
            DB::raw('DATE(goods_received_note.grn_date) as grn_date'),
            DB::raw('DATE(goods_received_note.po_date) as po_date'),
            DB::raw('DATE(goods_received_note.due_Date) as due_Date'),
            'goods_received_note.filename',
           
        )
        ->where('goods_received_note.grn_no', $grn_no)
        ->first();
        if ($grn) {
            $grn = $grn->toArray();
        
            // Convert the data to UTF-8 encoding
            array_walk_recursive($grn, function (&$value) {
                $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
            });
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
    
            // Check if the delete button was clicked and delete the attachments
            if ($request->has('delete_attachment') && $request->input('delete_attachment') === '1') {
                $grn->attachments = null;
                $grn->filename = null;
                $grn->save();
            }
    
            // Update the attachments if a new file is uploaded
            $file = $request->file('attachments');
            if ($file) {
                $fileData = file_get_contents($file->getRealPath());
                $fileName = $file->getClientOriginalName();
                
                $grn->attachments = $fileData;
                $grn->filename = $fileName;
                $grn->save();
            }
            // update the GRN item data
            $itemCount = count($request['item_no']);      
           $grn_delete=GoodsReceivedNoteItem::where('grn_no',$grn_no)->delete();
           for ($i = 0; $i < $itemCount; $i++) {     
            $update_pending_qty= $request['pending_qty'][$i]-$request['receiving_qty'][$i];           
            GoodsReceivedNoteItem::create([
            'grn_no'=>$grn_no, 
            'item_no' => $request['item_no'][$i],
            'pack_specification' => $request['pack_specification'][$i],
            'quantity' => $request['quantity'][$i],
            'rate_per_qty' => $request['rate_per_qty'][$i],
            'pending_qty' =>$update_pending_qty,
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