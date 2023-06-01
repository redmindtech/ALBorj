<?php

namespace App\Http\Controllers;

use App\Models\Expenses;
use App\Models\ProjectMaster;
use Illuminate\Http\Request;
use App\Http\Requests\ExpensesRequest;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Models\ExpensesCategoryMaster;
require_once(app_path('constants.php'));

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{  
            $source = SOURCE; 
            $vat = VAT;
            $exp_category = ExpensesCategoryMaster::select('category_name')->get();
            $expenses = DB::table('expenses')
            ->join('employee_masters', 'expenses.employee_no', '=', 'employee_masters.id')
            ->join('supplier_masters', 'expenses.supplier_no', '=', 'supplier_masters.supplier_no')
            ->join('project_masters', 'expenses.project_no', '=', 'project_masters.project_no')
            ->select('employee_masters.*', 'supplier_masters.*', 'project_masters.*', 'expenses.*',
            DB::raw('DATE(expenses.bill_date) as bill_date'))
            ->get();
            
            return view('expenses.index')->with([
                'expenses' => $expenses,
                'source'=>$source,
                'vat' => $vat,
                'exp_category'=>$exp_category
        ]);
    }
        catch (Exception $e) {
            info($e);
            return response()->json('Error occured in the index', 400);
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
    public function store(ExpensesRequest $request)
    {
         
         try {
            
            $exp_category = ExpensesCategoryMaster::select('category_name')->get();
            if ($exp_category->contains('category_name', $request['exp_category_no'])) {
                // the value of $request['exp_category_no'] exists in the $exp_category collection
                // do something here
                Expenses::create($request->only(Expenses::REQUEST_INPUTS));
                return response()->json('Expenses Details Created Successfully', 200);
    
            } else {
                // the value of $request['exp_category_no'] does not exist in the $exp_category collection
                // do something else here
                $new_category = ExpensesCategoryMaster::create([
                    'category_name' => $request['exp_category_no']
                ]);
                Expenses::create(array_merge($request->only(Expenses::REQUEST_INPUTS), [
                    'exp_category_no' => $new_category->category_name
                ]));
                return response()->json('Expenses Details Created Successfully', 200);
            }
            
        } catch (Exception $e) {
            info($e);
            return response()->json('Error occured in the store', 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expenses  $expenses
     * @return \Illuminate\Http\Response
     */
    public function show($exp_no)
    {
        try{  
        
            $expense = DB::table('expenses')
            ->join('employee_masters', 'expenses.employee_no', '=', 'employee_masters.id')
            ->join('supplier_masters', 'expenses.supplier_no', '=', 'supplier_masters.supplier_no')
            ->join('project_masters', 'expenses.project_no', '=', 'project_masters.project_no')
            ->select('employee_masters.*', 'supplier_masters.*', 'project_masters.*', 'expenses.*',
            DB::raw('DATE(expenses.bill_date) as bill_date'))
            ->where('expenses.exp_no', '=', $exp_no)
            ->get();
            
            return response()->json($expense);

        } catch (Exception $e) {
            info($e);
            return response()->json('Error occured in the show', 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expenses  $expenses
     * @return \Illuminate\Http\Response
     */
    public function edit(Expenses $expenses)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expenses  $expenses
     * @return \Illuminate\Http\Response
     */
    public function update(ExpensesRequest $request,  $exp_no)
    {
      
        try {
            $exp_category = ExpensesCategoryMaster::select('category_name')->get();
            if ($exp_category->contains('category_name', $request['exp_category_no'])) {

            $expense = Expenses::where('exp_no',$exp_no);
            $expense->update($request->only(Expenses::REQUEST_INPUTS));
            return response()->json('Expenses Details Updated Successfully');
            }else {
                // the value of $request['exp_category_no'] does not exist in the $exp_category collection
                // do something else here
                $new_category = ExpensesCategoryMaster::create([
                    'category_name' => $request['exp_category_no']
                ]);
                $expense = Expenses::where('exp_no',$exp_no);
                $expense->update($request->only(Expenses::REQUEST_INPUTS));
                return response()->json('Expenses Details Updated Successfully');
            }
        } 
        
        catch (Exception $e) {
            info($e);
            return response()->json('Error occured in the Expensesupdate', 400);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expenses  $expenses
     * @return \Illuminate\Http\Response
     */
    public function destroy($exp_no)
    {
        try {
            $expense = Expenses::where('exp_no',$exp_no);
            $expense->delete();
            return response()->json('Expense Details Deleted Successfully', 200);

        } catch (Exception $e) {
            info($e);
            return response()->json('Error occured in the delete', 400);
        }
    }
   
    
    
}
