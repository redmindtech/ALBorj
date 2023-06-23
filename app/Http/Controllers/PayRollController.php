<?php

namespace App\Http\Controllers;
use App\Models\PayRoll;
use App\Models\EmployeeMaster;
use App\Models\ProjectMaster;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PayrollDeduction;
use Illuminate\Support\Facades\DB;
use Exception;
require_once(app_path('constants.php'));

class PayRollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)

    {

        try
        {

            if ($request->session()->has('user')) {
              $employee=EmployeeMaster::pluck('firstname');
              $project_name=ProjectMaster::pluck('project_name');
              $payment_mode = PAYMENT_MODE;
              $month = MONTH;
            $payrolls = DB::table('employee_payroll')
            ->join('employee_masters','employee_payroll.employee_id', '=','employee_masters.id' )
            ->join('project_masters','employee_payroll.project_id', '=','project_masters.project_no' )
            ->select('employee_masters.*', 'employee_payroll.*','project_masters.*')
            ->where('employee_payroll.deleted','0')
            ->get();



            return view('payroll.index')->with([
                'payrolls' => $payrolls,
                'payment_mode' => $payment_mode,
                'employee'=>$employee,
                'project_name'=>$project_name,
                'month'=>$month


        ]);
    }else{
        return redirect("/");
    }
}

        catch (Exception $e) {
            info($e);
            return response()->json('Error occured in the store', 400);
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
            info($request);
            $payrolls=PayRoll::create($request->only(PayRoll::REQUEST_INPUTS));
            // $id = $payroll->id;
            $id= PayRoll::max('id');
              // Create PayrollDeduction records
              for ($i = 0; $i < count($request['deduction']); $i++) {
                PayrollDeduction::create([

                    'payroll_id' => $id,
                    'deduction' => $request['deduction'][$i],
                    'reason' => $request['reason'][$i],
                ]);
            }
              // Calculate and set the total deduction
        $totalDeduction = array_sum($request['deduction']);
        $payrolls->update(['total_deduction' => $totalDeduction]);

            return response()->json('PayRoll Details Created Successfully', 200);

            }
        catch (Exception $e) {
            info($e);
            return response()->json('Error occured in the store', 400);
           }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        try {

            $payrolls = DB::table('employee_payroll')
            ->join('employee_masters','employee_payroll.employee_id', '=','employee_masters.id' )
            ->join('project_masters', 'employee_payroll.project_id', '=', 'project_masters.project_no')
            ->select('employee_masters.*', 'employee_payroll.*','project_masters.project_name','project_masters.project_no')
            ->where('employee_payroll.id', $id)
            ->get();
            if ($payrolls) {
                $payrolls = $payrolls->toArray();

                // Convert the data to UTF-8 encoding
                array_walk_recursive($payrolls, function (&$value) {
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
            $payroll_deduction = DB::table('employee_payroll_deduction')
            ->join('employee_payroll','employee_payroll.id', '=','employee_payroll_deduction.payroll_id')
            ->select('employee_payroll.*','employee_payroll_deduction.*')
            ->where('employee_payroll_deduction.payroll_id', $id)
            ->get();

            return response()->json(['payrolls' =>$payrolls,
                  'payroll_deduction' =>$payroll_deduction,
        ]);

        } catch (Exception $e) {
            info($e);
            return response()->json('Error occured in the show', 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            // info($request);
            $payroll = PayRoll::findOrFail($id);
            $payroll->update($request->only(PayRoll::REQUEST_INPUTS));

            // Delete existing PayrollDeduction records for the given payroll ID
            $pay_delete=PayrollDeduction::where('payroll_id', $id)->delete();

            // Create new PayrollDeduction records
            for ($i = 0; $i < count($request['deduction']); $i++) {
                PayrollDeduction::create([
                    'payroll_id' => $id,
                    'deduction' => $request['deduction'][$i],
                    'reason' => $request['reason'][$i],
                ]);
            }
              // Calculate and set the total deduction
        $totalDeduction = array_sum($request['deduction']);
        $payroll->update(['total_deduction' => $totalDeduction]);

            return response()->json('PayRoll Details Updated Successfully', 200);
        } catch (Exception $e) {
            info($e);
            return response()->json('Error occurred during update', 400);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
    public function destroy($id)
{
    try {
        $payroll_deduction = PayrollDeduction::where('payroll_id', $id)->update(['deleted' => 1]);
        $payroll = PayRoll::where('id', $id)->update(['deleted' => 1]);
        return response()->json('PayRoll Details Deleted Successfully', 200);
    } catch (Exception $e) {
        info($e);
        return response()->json('Error occurred in the delete', 400);
    }
}



}