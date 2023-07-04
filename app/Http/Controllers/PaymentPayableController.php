<?php

namespace App\Http\Controllers;

use App\Models\PaymentPayable;
use App\Models\ProjectMaster;
use App\Models\GoodsReceivingNote;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// require_once(app_path('constants.php'));
class PaymentPayableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            // $payment_type = PAYMENT_TYPE;
            $project_name=ProjectMaster::pluck('project_name');
            $payment_payables = DB::table('payment_payable')
            ->join('goods_received_note', 'payment_payable.grn_no', '=', 'goods_received_note.grn_no')
            ->join('supplier_masters', 'goods_received_note.supplier_no', '=', 'supplier_masters.supplier_no')
            ->join('project_masters', 'goods_received_note.project_no', '=', 'project_masters.project_no')
            ->select(
                'goods_received_note.grn_code',
                'goods_received_note.grn_no',
                'goods_received_note.grn_date',
                'goods_received_note.supplier_no',
                'goods_received_note.project_no',
                'supplier_masters.name',
                'goods_received_note.grn_purchase_type',
                'goods_received_note.grn_invoice_no',
                'goods_received_note.due_Date',
                'goods_received_note.total_amount',
                'project_masters.project_name',
                'payment_payable.*'
            )
            ->where('payment_payable.deleted', '0')
            ->get();

                return view('paymentpayable.index')->with([
                    'payment_payables' => $payment_payables,
                    // 'payment_type' => $payment_type,
                    'project_name'=>$project_name,
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


        try {
            $rowIndex = $request->input('rowIndex');
            $grnDate = $request->input('grn_date');
            $projectNo = $request->input('project_no');
            $supplier=$request->input('supplier_no');
            info('go'.$supplier);
            if (is_array($grnDate) && isset($grnDate[$rowIndex])) {
                $grnDateValue = $grnDate[$rowIndex];
                // Use the $grnDateValue as needed
            } else {
                // Handle the case when $grnDate is not an array or $rowIndex is out of bounds
            }

            $grnNo = $request->input('grn_no');
            if (is_array($grnNo) && isset($grnNo[$rowIndex])) {
                $grnNoValue = $grnNo[$rowIndex];
                // Use the $grnNoValue as needed
            } else {
                // Handle the case when $grnNo is not an array or $rowIndex is out of bounds
            }

            $invoiceAmount = $request->input('invoice_amount');
            if (is_array($invoiceAmount) && isset($invoiceAmount[$rowIndex])) {
                $invoiceAmountValue = $invoiceAmount[$rowIndex];
                // Use the $invoiceAmountValue as needed
            } else {
                // Handle the case when $invoiceAmount is not an array or $rowIndex is out of bounds
            }


            $paymentType = $request->input('payment_mode');
            $paymentTypeValue = null; // Initialize the variable
            if (is_array($paymentType) && isset($paymentType[$rowIndex])) {
                $paymentTypeValue = $paymentType[$rowIndex];
                // Use the $paymentTypeValue as needed
            } else {
                // Handle the case when $paymentType is not an array or $rowIndex is out of bounds
            }

            $chequeNo = $request->input('cheque_no'); // Initialize the variable
            $chequeDate = $request->input('cheque_date'); // Initialize the variable
            // Check if the payment type is "cheque"
            if ($paymentTypeValue === 'cheque') {
                $chequeNo = $request->input('cheque_no');
                $chequeDate = $request->input('cheque_date');
            }


            $openingBalance = GoodsReceivingNote::where('supplier_no', $supplier)
            ->where('deleted', 0)
            ->where('pay_status', 0)
            ->sum('total_amount');
            // $previousClosingBalance = PaymentPayable::where('ap_no', $maxApNo)->value('closing_balance');
            $requestedAmount = $request->input('invoice_amount');
            $closingBalance = $openingBalance - $requestedAmount;

          // Check if the payment type is "cheque"
          if ($paymentType === 'cheque') {
              $chequeNo = $request->input('cheque_no');
              $chequeDate = $request->input('cheque_date');
          }

            $paymentPayables = PaymentPayable::create([
                'grn_date' => $grnDate,
                'grn_no' => $grnNo,
                'invoice_amount' => $invoiceAmount,
                // 'payable_amount' => $payableAmount,
                'payment_mode' => $paymentType,
                'cheque_no' => $chequeNo,
                'cheque_date' => $chequeDate,
                'project_no' => $projectNo,
                'opening_balance' => $openingBalance,
                'closing_balance' => $closingBalance,
            ]);
            // Update pay_status in goods_received_note table
            DB::table('goods_received_note')
                ->where('grn_no', $grnNo)
                ->update(['pay_status' => 1]);

            return response()->json('Payment Payable Details Added Successfully', 200);
        } catch (Exception $e) {
            info($e);
            return response()->json('Error occurred in the store', 400);
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymentPayable  $paymentPayable
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try
        {
            $payment_payables = DB::table('payment_payable')
            ->join('goods_received_note', 'payment_payable.grn_no', '=', 'goods_received_note.grn_no')
            ->join('supplier_masters', 'goods_received_note.supplier_no', '=', 'supplier_masters.supplier_no')
            ->join('project_masters', 'goods_received_note.project_no', '=', 'project_masters.project_no')
            ->select('goods_received_note.grn_code','goods_received_note.grn_no', 'goods_received_note.grn_date', 'goods_received_note.supplier_no', 'goods_received_note.project_no','supplier_masters.name','goods_received_note.grn_purchase_type','goods_received_note.grn_invoice_no','goods_received_note.due_Date','goods_received_note.total_amount', 'project_masters.project_name','payment_payable.*')
            ->where('payment_payable.ap_no', $id)
            ->get();
            return response()->json (['payment_payables' =>$payment_payables,
        ]);

        }
        catch (Exception $e)
        {
            info($e);
            return response()->json('Error occured in the show', 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentPayable  $paymentPayable
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentPayable $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaymentPayable  $paymentPayable
     * @return \Illuminate\Http\Response
     */

//
public function update(Request $request, $id)
{
    try {
        $paymentPayable = PaymentPayable::where('ap_no', $id)->first();
        if (!$paymentPayable) {
            return response()->json('Payment Payable not found', 404);
        }

        $grnDate = $request->input('grn_date');
        $chequeDate = $request->input('cheque_date');

        $grnDate = date('Y-m-d', strtotime($grnDate));
        $chequeDate = date('Y-m-d', strtotime($chequeDate));

        $paymentPayable->grn_date = $grnDate;
        $paymentPayable->cheque_date = $chequeDate;
        $paymentPayable->cheque_no = $request->input('cheque_no');
        $paymentPayable->grn_no = $request->input('grn_no');
        $paymentPayable->invoice_amount = $request->input('invoice_amount');
        $paymentPayable->payment_mode = $request->input('payment_mode');

        // Retrieve the supplier number from the paymentPayable object
        $supplier = $paymentPayable->supplier_no;

        // Calculate the opening_balance and closing_balance based on the requestedAmount
        $openingBalance = GoodsReceivingNote::where('supplier_no', $supplier)
            ->where('deleted', 0)
            ->where('pay_status', 0)
            ->sum('total_amount');

        $requestedAmount = $request->input('invoice_amount');
        $closingBalance = $openingBalance - $requestedAmount;

        $paymentPayable->payable_amount = $requestedAmount;
        $paymentPayable->opening_balance = $openingBalance;
        $paymentPayable->closing_balance = $closingBalance;

        $paymentPayable->save();

        return response()->json('Payment Payable Details Updated Successfully');
    } catch (Exception $e) {
        info($e);
        return response()->json('Error occurred in the update', 400);
    }
}
 /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentPayable  $paymentPayable
     * @return \Illuminate\Http\Response
     */

public function destroy($id)
{
    try {

        $paymentPayable = PaymentPayable::where('ap_no', $id)->update(['deleted' => 1]);
        return response()->json('Payment payable deleted successfully', 200);
    } catch (Exception $e) {
        info($e);
        return response()->json('Error occurred in the delete', 400);
    }
}

}