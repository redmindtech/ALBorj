<?php

namespace App\Http\Controllers;
use App\Models\ExpensesCategoryMaster;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ExpensesCategoryMasterController extends Controller
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
           
            $expenses = ExpensesCategoryMaster::all();
            $categoryNames = $expenses->pluck('category_name')->map(function ($name) {
                return strtolower(str_replace(' ', '', $name));
            });
            return view('expensescategorymaster.index')->with([
                'expenses' => $expenses,
                'categoryNames'=>$categoryNames
            ]);
        }
        catch (Exception $e)
        {
            info($e);
            return response()->json('Error occured in the loading page', 400);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

   /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try 
        {
            $expenses = ExpensesCategoryMaster::findOrFail($id);
            $expenses->delete();
            return response()->json('ExpensesCategory Details Deleted Successfully', 200);

        } 
        catch (Exception $e) 
        {
            info($e);
            return response()->json('Error occured in the edit', 400);
        }
    }
}