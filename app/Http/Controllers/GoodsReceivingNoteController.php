<?php

namespace App\Http\Controllers;

use App\Http\Requests\GoodReceivingNoteRequest;
use App\Models\GoodsReceivingNote;
use App\Models\GoodsReceivedNoteItem;
use App\Models\ItemMaster;
use App\Models\ItemSupplier;
use App\Models\ProjectMaster;
use App\Models\PurchaseOrder;
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
        try 
        {
            $purchase_type = PROJECTORDERTYPE;

            if (session()->has('user')) {
            $item=ItemMaster::all();
            $item_name=$item->pluck('item_name');
            $project = ProjectMaster::all();
            $project_name=$project->pluck('project_name');
            $purchase = PurchaseOrder::all();
            $purchase_order = $purchase->pluck('po_code');
            $grn = GoodsReceivingNote::join('project_masters', 'goods_received_note.project_no', '=', 'project_masters.project_no')
            ->join('supplier_masters', 'goods_received_note.supplier_no', '=', 'supplier_masters.supplier_no')                 
            ->select('goods_received_note.*', 'project_masters.*', 'supplier_masters.*')  
            ->where('goods_received_note.deleted','0')          
            ->get();
            return view('goodsreceivingnote.index')
            ->with([
                'purchase_type' => $purchase_type,
                'grns'=>$grn,
                'project_name' => $project_name,
                'item_name' => $item_name,
                'purchase_order' => $purchase_order,
             ]);
            }else{
                return redirect("/");
            }
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
        if (!isset($request['dis_type'])) {
            // The 'dis_type' key exists in the $request array
            // Perform your desired actions here
            $request['dis_type']=1;
        }
        
         
        $file = $request->file('attachments');        
        $po_no=$request['po_no'];
        $purchase_type=$request['grn_purchase_type'];
        $update_pending_qty_array = [];

        try {
            // grn insert data
            $grn = new GoodsReceivingNote($request->only(GoodsReceivingNote::REQUEST_INPUTS));
                if ($file)
                {
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
                {  $item_no=$request['item_no'][$i];
                    $update_pending_qty= $request['pending_qty'][$i]-$request['receiving_qty'][$i];    
                    $update_pending_qty_array[] = $update_pending_qty;        
                 if($purchase_type =="Local Purchase Order" || $purchase_type =="Cash purchase")
                {
                    // $item_no=$request['item_no'][$i];
                   //  update total qty in itemmaster table
                    $item_update = ItemMaster::where('id', $item_no)->value('total_quantity');                                     
                    $item_qty=$item_update+ $request['receiving_qty'][$i];                     
                    ItemMaster::where('id', $item_no)
                    ->update(['total_quantity' => $item_qty]);
                    // ITEM_SUPPLIER QUANTITY UPDATE OR CREATE NEW
                    $item_supplier_check = ItemSupplier::where('item_no', $item_no)
                    ->where('supplier_no', $supplier_no)->value('quantity');                        
                                
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
                 else
                     {
                        $item_supplier_qty=$item_supplier_check+$request['receiving_qty'][$i];    
                        // update itemsupplier quantity and rate per qty
                        $item_supplier_check = ItemSupplier::where('item_no', $item_no)
                        ->where('supplier_no', $supplier_no)->update(['quantity' => $item_supplier_qty, 'price_per_qty'=>$request['rate_per_qty'][$i]
                        ]); 

                     }
                 }
                    // update pending qty in PURCHASE ORDER ITEM
                    DB::table('purchase_order_item')
                    ->where('po_no',$po_no)
                    ->where('item_no',$item_no)
                    ->update(['pending_qty' => $update_pending_qty]);
                
                // data added in grn item table
                    GoodsReceivedNoteItem::create([
                    'grn_no'=>$grn, 
                    'item_no' => $request['item_no'][$i],
                    'pack_specification' => $request['pack_specification'][$i],
                    'quantity' => $request['quantity'][$i],
                    'rate_per_qty' => $request['rate_per_qty'][$i],
                    'pending_qty' => $update_pending_qty,
                    'item_amount' => $request['item_amount'][$i],
                    'receiving_qty'=>$request['receiving_qty'][$i]
                    ]); 
                }
                 //UPDATEPENDING QUANTITY STATUS
                //  info($update_pending_qty_array);
                 // update po_status in purchase order table
                 $hasNonZeroValue = false;
                    foreach ($update_pending_qty_array as $value) {
                        if ($value != 0) {
                            $hasNonZeroValue = true;
                            break;
                        }
                    }

                    // Check if any non-zero value is present
                    if (!$hasNonZeroValue) {
                        // Code when all values in $update_pending_qty_array are zero
                        $pendingQty = DB::table('purchase_order')
                            ->where('po_no', $po_no)
                            ->update(['po_status' => '1']);
}



           
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
            $grn_item_edit=GoodsReceivedNoteItem::     
            join('item_masters', 'goods_received_note_item.item_no', '=', 'item_masters.id')                       
            ->select( 'goods_received_note_item.*', 'item_masters.*')
            ->where('goods_received_note_item.grn_no', $grn_no)  
            ->where('pending_qty', '!=', 0)      
            ->get();    
         
             return response()->json([
                'grn' => $grn,
                'grn_item' => $grn_item,
                'grn_item_edit'=>$grn_item_edit
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
        $po_no=$request['po_no'];
        $purchase_type=$request['grn_purchase_type'];
        if (!isset($request['dis_type'])) {
            // The 'dis_type' key exists in the $request array
            // Perform your desired actions here
            $request['dis_type']=1;
        }
        
        try {
            $grn = GoodsReceivingNote::where('grn_no', $grn_no)->first();
            $grossAmount = $grn->gross_amount;
            $supplier_no=$request['supplier_no']; 
            info($grossAmount);
            if($request['gross_amount'] != $grossAmount){
              $gross_amt= $request['gross_amount']-$grossAmount;
               info($gross_amt); 
                            
                $closing_bal_check=DB::table('accounts_payables')         
                ->where('supplier_no', $supplier_no)
                ->max('ap_no');  
                if($closing_bal_check !="")
                {
                    $closing_bal_add=DB::table('accounts_payables')
                    ->where('ap_no',  $closing_bal_check)
                    ->value('closing_balance');
                    info($closing_bal_add);
                    $closing_bal=$closing_bal_add+$gross_amt;
                    info($closing_bal);
                    DB::table('accounts_payables')
                    ->where('ap_no',  $closing_bal_check)
                    ->update(['closing_balance' => $closing_bal]); 
                 }
                }

            
             $grn->update($request->only(GoodsReceivingNote::REQUEST_INPUTS));
    
        //     // Check if the delete button was clicked and delete the attachments
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
        //    $grn_delete=GoodsReceivedNoteItem::where('grn_no',$grn_no)->delete();
           for ($i = 0; $i < $itemCount; $i++) {    
            $grnItem = GoodsReceivedNoteItem::where([
                'grn_no' => $grn_no,
                'item_no' => $request['item_no'][$i],
            ])->first();
            $receivingQty = $grnItem->receiving_qty;
            info($receivingQty);
            if($receivingQty != $request['receiving_qty'][$i]){

                if($purchase_type =="Local Purchase Order" || $purchase_type =="Cash purchase")
                {
                   $qty= $request['receiving_qty'][$i]- $receivingQty;
                   info($qty);
                        $item_no=$request['item_no'][$i];
                 //  update total qty in itemmaster table
                        $item_update = ItemMaster::where('id', $item_no)->value('total_quantity');                                     
                        $item_qty= $item_update + $qty;                     
                        ItemMaster::where('id', $item_no)
                        ->update(['total_quantity' => $item_qty]);
                        
                 // ITEM_SUPPLIER QUANTITY UPDATE OR CREATE NEW
                        $item_supplier_check = ItemSupplier::where('item_no', $item_no)
                        ->where('supplier_no', $supplier_no)->value('quantity');                        
                                      
                        $item_supplier_qty=$item_supplier_check+$qty;    
                // update itemsupplier quantity and rate per qty
                              $item_supplier_check = ItemSupplier::where('item_no', $item_no)
                            ->where('supplier_no', $supplier_no)->update(['quantity' => $item_supplier_qty, 'price_per_qty'=>$request['rate_per_qty'][$i]
                        ]); 

                        $update_pending_qty= $request['pending_qty'][$i]+$qty;     

                        GoodsReceivedNoteItem::where([
                            'grn_no' => $grn_no,
                            'item_no' => $request['item_no'][$i],
                        ])->update([
                            'pack_specification' => $request['pack_specification'][$i],
                            'quantity' => $request['quantity'][$i],
                            'rate_per_qty' => $request['rate_per_qty'][$i],
                            'pending_qty' => $update_pending_qty,
                            'item_amount' => $request['item_amount'][$i],
                            'receiving_qty'=>$request['receiving_qty'][$i]

                        ]);
                        // update pending qty in PURCHASE ORDER ITEM
                        DB::table('purchase_order_item')
                        ->where('po_no',$po_no)
                        ->update(['pending_qty' => $update_pending_qty]);
                    }
    
                    else
                    {
                        // $update_pending_qty= $request['pending_qty'][$i]-$request['receiving_qty'][$i];      
                        $qty= $request['receiving_qty'][$i]- $receivingQty;
                        $update_pending_qty= $request['pending_qty'][$i]+$qty;    
                        GoodsReceivedNoteItem::where([
                            'grn_no' => $grn_no,
                            'item_no' => $request['item_no'][$i],
                        ])->update([
                            'pack_specification' => $request['pack_specification'][$i],
                            'quantity' => $request['quantity'][$i],
                            'rate_per_qty' => $request['rate_per_qty'][$i],
                            'pending_qty' =>$update_pending_qty,
                            'item_amount' => $request['item_amount'][$i],
                            'receiving_qty'=>$request['receiving_qty'][$i]
                        ]);
                        // update pending qty in PURCHASE ORDER ITEM
                        DB::table('purchase_order_item')
                        ->where('po_no',$po_no)
                        ->update(['pending_qty' => $request['pending_qty'][$i]]);
                                
                    }
                }
                else{
                    GoodsReceivedNoteItem::where([
                        'grn_no' => $grn_no,
                        'item_no' => $request['item_no'][$i],
                    ])->update([
                        'pack_specification' => $request['pack_specification'][$i],
                        'quantity' => $request['quantity'][$i],
                        'rate_per_qty' => $request['rate_per_qty'][$i],
                        'pending_qty' => $request['pending_qty'][$i],
                        'item_amount' => $request['item_amount'][$i],
                        'receiving_qty'=>$request['receiving_qty'][$i]

                    ]);  
                }
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
            return response()->json('Goods Receiving Note Deleted Successfully', 200);
        } catch (Exception $e) {
            info($e);
            return response()->json('Error occured in the delete', 400);
        }
    } 
  
}