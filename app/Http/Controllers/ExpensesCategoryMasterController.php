<?php

namespace App\Http\Controllers;
use App\Models\ExpensesCategoryMaster;

use Exception;

use App\Http\Requests\ExpensesCategoryRequest;
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
            //info($expenses);
            $expenses = ExpensesCategoryMaster::all();
            return view('expensescategorymaster.index')->with([
                'expenses' => $expenses
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
    public function store(ExpensesCategoryRequest $request)
    {
        try {
            ExpensesCategoryMaster::create($request->only(ExpensesCategoryMaster::REQUEST_INPUTS));
            return response()->json('ExpensesCategory Master Created Successfully', 200);

        } catch (Exception $e) {
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
        try {
            $expenses = ExpensesCategoryMaster::findOrFail($id);
            return response()->json($expenses);

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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // UPDATE SAVE FUNCTION
    public function update(ExpensesCategoryRequest $request, $id)
    {
        try {
            $expenses = ExpensesCategoryMaster::findOrFail($id);
            $expenses->update($request->only(ExpensesCategoryMaster::REQUEST_INPUTS));
            return response()->json('ExpensesCategory Master Updated Successfully');

        } catch (Exception $e) {
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
        try {
            $expenses = ExpensesCategoryMaster::findOrFail($id);
            $expenses->delete();
            return response()->json('ExpensesCategory Master Deleted Successfully', 200);

        } catch (Exception $e) {
            info($e);
            return response()->json('Error occured in the edit', 400);
        }
    }
}