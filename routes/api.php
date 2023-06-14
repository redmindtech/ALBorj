<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::get('/client_data',[App\Http\Controllers\ClientMasterController::class, 'client_data'])->name('client_data');
// Route::get('/supplier_edit_data',[App\Http\Controllers\SupplierMasterController::class, 'supplier_edit_data'])->name('supplier_edit_data');
// Route::get('/edit_data',[App\Http\Controllers\ItemMasterController::class, 'edit_data'])->name('edit_data');
// Route::get('/getData',[App\Http\Controllers\ItemMasterController::class, 'getData'])->name('getData');
// Route::get('/sitegetData',[App\Http\Controllers\SiteMasterController::class, 'sitegetData'])->name('sitegetData');
// Route::get('/data_edit',[App\Http\Controllers\SiteMasterController::class, 'data_edit'])->name('data_edit');
// Route::get('/project_data',[App\Http\Controllers\ProjectMasterController::class, 'project_data'])->name('project_data');
// Route::get('/ProjectGetData',[App\Http\Controllers\ProjectMasterController::class, 'ProjectGetData'])->name('ProjectGetData');
// Route::get('/ProjectManagerData',[App\Http\Controllers\ProjectMasterController::class, 'ProjectManagerData'])->name('ProjectManagerData');
// Route::get('/employee_data',[App\Http\Controllers\EmployeeMasterController::class, 'employee_data'])->name('employee_data');

//suppliers
Route::post("/supplier", [App\Http\Controllers\SupplierMasterController::class, 'store'])->name('supplierApi.store');
Route::post("/supplier/{supplier}/update", [App\Http\Controllers\SupplierMasterController::class, 'update'])->name('supplierApi.update');
Route::delete("/supplier/{supplier}/delete", [App\Http\Controllers\SupplierMasterController::class, 'destroy'])->name('supplierApi.delete');
Route::get("/supplier/{supplier}/show", [App\Http\Controllers\SupplierMasterController::class, 'show'])->name('supplierApi.show');
Route::get("/getSupplier", [App\Http\Controllers\SupplierMasterController::class, 'getSupplier'])->name('getSupplier');
//sitemaster
 Route::post("/site", [App\Http\Controllers\SiteMasterController::class, 'store'])->name('siteApi.store');
 Route::post("/site/{site_no}/update", [App\Http\Controllers\SiteMasterController::class, 'update'])->name('siteApi.update');
 Route::delete("/site/{site_no}/delete", [App\Http\Controllers\SiteMasterController::class, 'destroy'])->name('siteApi.delete');
 Route::get("/site/{site_no}/show", [App\Http\Controllers\SiteMasterController::class, 'show'])->name('siteApi.show');

// client master
 Route::post("/client", [App\Http\Controllers\ClientMasterController::class, 'store'])->name('clientApi.store');
Route::post("/client/{client}/update", [App\Http\Controllers\ClientMasterController::class, 'update'])->name('clientApi.update');
Route::delete("/client/{client}/delete", [App\Http\Controllers\ClientMasterController::class, 'destroy'])->name('clientApi.delete');
Route::get("/client/{client}/show", [App\Http\Controllers\ClientMasterController::class, 'show'])->name('clientApi.show');
// project master
Route::post("/project", [App\Http\Controllers\ProjectMasterController::class, 'store'])->name('projectApi.store');
 Route::post("/project/{project_no}/update", [App\Http\Controllers\ProjectMasterController::class, 'update'])->name('projectApi.update');
 Route::delete("/project/{project_no}/delete", [App\Http\Controllers\ProjectMasterController::class, 'destroy'])->name('projectApi.delete');
Route::get("/project/{project_no}/show", [App\Http\Controllers\ProjectMasterController::class, 'show'])->name('projectApi.show');

// AUTOCOMPLETE
Route::get("/getautocompletesite", [App\Http\Controllers\AutoCompleteController::class, 'getemployeedata'])->name('getemployeedata');
Route::get("/getsitenoautocomplete", [App\Http\Controllers\AutoCompleteController::class, 'getsitedata'])->name('getsitedata');
Route::get("/getclientnoautocomplete", [App\Http\Controllers\AutoCompleteController::class, 'getclientdata'])->name('getclientdata');
Route::get("/getitemdata", [App\Http\Controllers\AutoCompleteController::class, 'getlocdata'])->name('getlocdata');
Route::get("/getitemnamedata", [App\Http\Controllers\AutoCompleteController::class, 'getitemnamedata'])->name('getitemnamedata');
Route::get("/getautocomplete", [App\Http\Controllers\AutoCompleteController::class, 'getempdata'])->name('getempdata');
Route::get("/get_po_details", [App\Http\Controllers\AutoCompleteController::class, 'get_po_details'])->name('get_po_details');
Route::get("/getsitelocationdata", [App\Http\Controllers\AutoCompleteController::class, 'getsitelocationdata'])->name('getsitelocationdata');
Route::get("/getpopricedata", [App\Http\Controllers\AutoCompleteController::class, 'getpopricedata'])->name('getpopricedata');
Route::get("/getmrdata", [App\Http\Controllers\PurchaseOrderController::class, 'getmrdata'])->name('getmrdata');
Route::get("/purchase_return_data", [App\Http\Controllers\AutoCompleteController::class, 'purchase_return_data'])->name('purchase_return_data');
Route::get("/getempdata_supplier_company", [App\Http\Controllers\AutoCompleteController::class, 'getempdata_supplier_company'])->name('getempdata_supplier_company');
Route::get("/getmrcode",[App\Http\Controllers\AutoCompleteController::class,'getmrcode'])->name('getmrcode');

// item master
Route::post("/item", [App\Http\Controllers\ItemMasterController::class, 'store'])->name('store');
Route::post("/item/{item}/update", [App\Http\Controllers\ItemMasterController::class, 'update'])->name('itemApi.update');
Route::delete("/item/{item}/delete", [App\Http\Controllers\ItemMasterController::class, 'destroy'])->name('itemApi.delete');
Route::get("/item/{item}/show", [App\Http\Controllers\ItemMasterController::class, 'show'])->name('itemApi.show');
Route::get("/getitem", [App\Http\Controllers\ItemMasterController::class, 'getitem'])->name('getitem');

// employee master
Route::post("/employee",[App\Http\Controllers\EmployeeMasterController::class, 'store'])->name('employeeApi.store');
Route::post("/employee/{employee}/update", [App\Http\Controllers\EmployeeMasterController::class, 'update'])->name('employeeApi.update');
Route::delete("/employee/{employee}/delete", [App\Http\Controllers\EmployeeMasterController::class, 'destroy'])->name('employeeApi.delete');
Route::get("/employee/{employee}/show", [App\Http\Controllers\EmployeeMasterController::class, 'show'])->name('employeeApi.show');
Route::get("/getEmployee", [App\Http\Controllers\EmployeeMasterController::class, 'getEmployee'])->name('getEmployee');
//expensescategory master
Route::post("/expensescategory", [App\Http\Controllers\ExpensesCategoryMasterController::class, 'store'])->name('expensescategoryApi.store');
Route::post("/expensescategory/{expenses}/update", [App\Http\Controllers\ExpensesCategoryMasterController::class, 'update'])->name('expensescategoryApi.update');
Route::delete("/expensescategory/{expenses}/delete", [App\Http\Controllers\ExpensesCategoryMasterController::class, 'destroy'])->name('expensescategoryApi.delete');
Route::get("/expensescategory/{expenses}/show", [App\Http\Controllers\ExpensesCategoryMasterController::class, 'show'])->name('expensescategoryApi.show');
// Expenses
Route::post("/expense",[App\Http\Controllers\ExpensesController::class, 'store'])->name('expenseApi.store');
Route::post("/expense/{expense}/update", [App\Http\Controllers\ExpensesController::class, 'update'])->name('expenseApi.update');
Route::delete("/expense/{expense}/delete", [App\Http\Controllers\ExpensesController::class, 'destroy'])->name('expenseApi.delete');
Route::get("/expense/{expense}/show", [App\Http\Controllers\ExpensesController::class, 'show'])->name('expenseApi.show');


// GRN
Route::post("/GRN",[App\Http\Controllers\GoodsReceivingNoteController::class, 'store'])->name('grnApi.store');
Route::post("/GRN/{grnid}/update", [App\Http\Controllers\GoodsReceivingNoteController::class, 'update'])->name('grnApi.update');
Route::get("/GRN/{grnid}/{po_no}show", [App\Http\Controllers\GoodsReceivingNoteController::class, 'show'])->name('grnApi.show');
Route::get("/GRN/{grnid}/delete", [App\Http\Controllers\GoodsReceivingNoteController::class, 'delete'])->name('gdelete');
// material Issue
Route::post("/materialissue", [App\Http\Controllers\MaterialIssueController::class, 'store'])->name('materialissueApi.store');
Route::post("/materialissue/{mir_no}/update", [App\Http\Controllers\MaterialIssueController::class, 'update'])->name('materialissueApi.update');
Route::delete("/materialissue/{mir_no}/delete", [App\Http\Controllers\MaterialIssueController::class, 'destroy'])->name('materialissueApi.delete');
Route::get("/materialissue/{mir_no}/show", [App\Http\Controllers\MaterialIssueController::class, 'show'])->name('materialissueApi.show');
// MaterialRequisition
Route::post("/materialrequisition", [App\Http\Controllers\MaterialRequisitionController::class, 'store'])->name('material.store');
Route::get("/materialrequisition/{id}/show", [App\Http\Controllers\MaterialRequisitionController::class, 'show'])->name('material.show');
Route::delete("/materialrequisition/{id}/delete", [App\Http\Controllers\MaterialRequisitionController::class, 'destroy'])->name('material.delete');
Route::post("/materialrequisition/{id}/update", [App\Http\Controllers\MaterialRequisitionController::class, 'update'])->name('material.update');
// Employee Timesheet
Route::post("/timesheet",[App\Http\Controllers\TimeSheetController::class, 'store'])->name('timesheetApi.store');
Route::post("/timesheet/{timesheet}/update", [App\Http\Controllers\TimeSheetController::class, 'update'])->name('timesheetApi.update');
Route::delete("/timesheet/{timesheet}/delete", [App\Http\Controllers\TimeSheetController::class, 'destroy'])->name('timesheetApi.delete');
Route::get("/timesheet/{timesheet}/show", [App\Http\Controllers\TimeSheetController::class, 'show'])->name('timesheetApi.show');

//purchaseorder
Route::post("/purchaseorder", [App\Http\Controllers\PurchaseOrderController::class, 'store'])->name('purchaseorderApi.store');
Route::post("/purchaseorder/{po_no}/update", [App\Http\Controllers\PurchaseOrderController::class, 'update'])->name('purchaseorderApi.update');
Route::delete("/purchaseorder/{po_no}/delete", [App\Http\Controllers\PurchaseOrderController::class, 'destroy'])->name('purchaseorderApi.delete');
Route::get("/purchaseorder/{po_no}/show", [App\Http\Controllers\PurchaseOrderController::class, 'show'])->name('purchaseorderApi.show');
// purchaseReturn
Route::post("/purchasereturn", [App\Http\Controllers\PurchaseReturnController::class, 'store'])->name('prApi.store');
Route::get("/purchasereturn/{pr_no}/show", [App\Http\Controllers\PurchaseReturnController::class, 'show'])->name('prApi.show');
Route::post("/purchasereturn/{pr_no}/update", [App\Http\Controllers\PurchaseReturnController::class, 'update'])->name('prApi.update');
Route::delete("/purchasereturn/{pr_no}/delete", [App\Http\Controllers\PurchaseReturnController::class, 'delete'])->name('prApi.delete');
