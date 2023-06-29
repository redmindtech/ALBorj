<?php

namespace App\Http\Controllers;
use App\Models\ExpensesCategoryMaster;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ExpensesCategoryMasterController extends Controller
{
    // FOR LOADING PAGE
    public function index()
    {
        try
        {
            if (session()->has('user')) {
                $expenses = ExpensesCategoryMaster::where('deleted', 0)
                ->get();
            
                $categoryNames = $expenses->where('deleted', 0)
                ->pluck('category_name')
                ->map(function ($name) {
                    return strtolower(str_replace(' ', '', $name));
                });
            
            return view('expensescategorymaster.index')->with([
                'expenses' => $expenses,
                'categoryNames'=>$categoryNames
            ]);
        }
    
        else{
            return redirect("/");
        }}
        catch (Exception $e)
        {
            info($e);
            return response()->json('Error occured in the loading page', 400);
        }

    }

    
    // DATA SAVE IN ADD DIALOG
    public function store(Request $request)
    {
        try 
        {
            ExpensesCategoryMaster::create($request->only(ExpensesCategoryMaster::REQUEST_INPUTS));
            return response()->json('ExpensesCategory Details Added Successfully', 200);

        } 
        catch (Exception $e)
        {
            info($e);
            return response()->json('Error occured in the store', 400);
        }
    }

     
    // DATA SHOW WHICH IS USED FOR EDIT AND SHOW
    public function show($id)
    {
        try 
        {
            $expenses = ExpensesCategoryMaster::findOrFail($id);
            return response()->json($expenses);

        } 
        catch (Exception $e) 
        {
            info($e);
            return response()->json('Error occured in the show', 400);
        }
    }

    // UPDATE SAVE FUNCTION
    public function update(Request $request, $id)
    {
        try 
        {
            $expenses = ExpensesCategoryMaster::findOrFail($id);
            $expenses->update($request->only(ExpensesCategoryMaster::REQUEST_INPUTS));
            return response()->json('ExpensesCategory Details Updated Successfully');

        } 
        catch (Exception $e)
        {
            info($e);
            return response()->json('Error occured in the update', 400);
        }
    }

    // DELETE FUNCTION
    public function destroy($id)
    {
        try 
        {
            $expenses = ExpensesCategoryMaster::findOrFail($id);
            $expenses->update(['deleted' => 1]);
            return response()->json('ExpensesCategory Details Deleted Successfully', 200);

        } 
        catch (Exception $e) 
        {
            info($e);
            return response()->json('Error occured in the edit', 400);
        }
    }
}