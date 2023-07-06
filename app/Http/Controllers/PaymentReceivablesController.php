<?php

namespace App\Http\Controllers;

use App\Models\PaymentReceivables;
use App\Http\Controllers\Controller;
use App\Models\PaymentReceivablesItem;
use App\Models\ProjectMaster;
use App\Models\ProjectMasterItem;
use Illuminate\Http\Request;
require_once(app_path('constants.php'));
class PaymentReceivablesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { try{
        $source = SOURCE;
        $projectmasters = ProjectMaster::where('deleted', 0)->get();
        $projectName = $projectmasters->pluck('project_name')->map(function ($name) {
            return strtolower(str_replace(' ', '', $name));
        });
       $payment_recs= PaymentReceivables::join('project_masters','payment_receivables.project_no','=','project_masters.project_no')
        ->where('payment_receivables.deleted','=','0')
        ->select('project_masters.project_no','project_masters.project_name','payment_receivables.*')
        ->get();
        // info($payment_recs);
        return  view('paymentreceivables.index')
            ->with([
                'payment_recs' => $payment_recs,
                'source'=>$source,
                'projectName'=>$projectName
                
             ]);
            }
    
    catch (Exception $e) {
        info($e);
        return response()->json('Error occured in Payment Receivables index',400);
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
        try{
            
            // $payment_receivables_id= PaymentReceivables::where('deleted',0)->where('project_no',$request['project_no'])->max('id');
            // info($payment_receivables_id);
            // if($payment_receivables_id != "")
            // {
            //     $request['opening_bal']= PaymentReceivables::where('deleted',0)->where('id',$payment_receivables_id)->value('closing_bal');
            
            // }
            // else{
            //     $request['opening_bal']=$request['project_cost'];
            // }
            // info($request['opening_bal']);
            // $request['closing_bal']=$request['opening_bal']-$request['received_amt'];

         $payment_receivables = PaymentReceivables::create($request->only(PaymentReceivables::REQUEST_INPUTS));
         $id=PaymentReceivables::max('id');
        $item_no=count($request['item_no']);
       
        for ($i = 0; $i < $item_no ; $i++) {
            $project=ProjectMasterItem::where('proj_no',$request['project_no'])->where('item_no',$request['item_no'][$i])->value('pending_qty');
           
            $pending_qty = $project - $request['used_qty'][$i];
           
            ProjectMasterItem::where('proj_no', $request['project_no'])
                ->where('item_no', $request['item_no'][$i])
                ->update(['pending_qty' => $pending_qty]);
            
            PaymentReceivablesItem::create([
               'proj_receiv_no'=>$id,
               'item_no' => $request['item_no'][$i],
               'specification' => $request['specification'][$i],
               'qty' => $request['qty'][$i],
               'used_qty' => $request['used_qty'][$i],
               'rate_per_qty' => $request['rate_per_qty'][$i],
               'remaining_qty' => $request['remaining_qty'][$i],               
                'amount' => $request['amount'][$i]
              
            ]);
        }
        
        return response()->json('Payment Receivables created Successfully',200);
    
        } catch (Exception $e) {
            info($e);
            return response()->json('Error occured in Payment Receivables store',400);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymentReceivables  $paymentReceivables
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $payment_recs= PaymentReceivables::join('project_masters','payment_receivables.project_no','=','project_masters.project_no')
       
        ->where('payment_receivables.deleted','=','0')
        ->where('payment_receivables.id',$id)
        ->select('project_masters.project_no','project_masters.project_name','project_masters.project_name','payment_receivables.*')
        ->first();
       
        $payment_item = PaymentReceivablesItem::join('item_masters', 'payment_receivables_item.item_no', '=', 'item_masters.id')
        ->join('project_master_item', 'item_masters.id', '=', 'project_master_item.item_no')
        ->join('payment_receivables', function ($join) {
            $join->on('project_master_item.proj_no', '=', 'payment_receivables.project_no')
                ->on('payment_receivables_item.proj_receiv_no', '=', 'payment_receivables.id');
        })
        ->where('payment_receivables_item.deleted', '0')
        ->where('payment_receivables_item.proj_receiv_no', $id)
        ->select('item_masters.*', 'payment_receivables_item.*', 'project_master_item.pending_qty')
        ->distinct()
        ->get();
    

        return response()->json([
            'payment_recs' => $payment_recs,
            'payment_item'=>$payment_item
    
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentReceivables  $paymentReceivables
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentReceivables $paymentReceivables)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaymentReceivables  $paymentReceivables
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
    
        try{
        $payment_receivables = PaymentReceivables::where('id', $id)->first();
              
        $payment_receivables->update($request->only(PaymentReceivables::REQUEST_INPUTS));
        $item_no=count($request['item_no']);

        PaymentReceivablesItem::where('proj_receiv_no',$id)->delete();

        for ($i = 0; $i < $item_no ; $i++) {
            PaymentReceivablesItem::create([
               'proj_receiv_no'=>$id,
               'item_no' => $request['item_no'][$i],
               'specification' => $request['specification'][$i],
               'qty' => $request['qty'][$i],
               'used_qty' => $request['used_qty'][$i],
               'rate_per_qty' => $request['rate_per_qty'][$i],
               'remaining_qty' => $request['remaining_qty'][$i],               
                'amount' => $request['amount'][$i]
              
            ]);
        }
        return response()->json('Payment Receivables updated successfully', 200);
    } catch (Exception $e) {
        info($e);
        return response()->json('Error occurred while updating Payment Receivables', 400);
    }
          
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentReceivables  $paymentReceivables
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
        $payment_receivables = PaymentReceivables::where('id', $id)->first();
        $payment_receivables->update(['deleted'=>'1']);
        PaymentReceivablesItem::where('proj_receiv_no',$id)->update(['deleted'=>'1']);
        return response()->json('Payment Receivables Deleted Successfully', 200);
    } catch (Exception $e) {
        info($e);
        return response()->json('Error occured in the delete', 400);
    }
        }
    
}
