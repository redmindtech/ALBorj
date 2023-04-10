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

Route::get('/client_data',[App\Http\Controllers\ClientMasterController::class, 'client_data'])->name('client_data');
Route::get('/supplier_edit_data',[App\Http\Controllers\SupplierMasterController::class, 'supplier_edit_data'])->name('supplier_edit_data');
Route::get('/edit_data',[App\Http\Controllers\ItemMasterController::class, 'edit_data'])->name('edit_data');
Route::get('/getData',[App\Http\Controllers\ItemMasterController::class, 'getData'])->name('getData');
Route::get('/sitegetData',[App\Http\Controllers\SiteMasterController::class, 'sitegetData'])->name('sitegetData');
Route::get('/data_edit',[App\Http\Controllers\SiteMasterController::class, 'data_edit'])->name('data_edit');
Route::get('/project_data',[App\Http\Controllers\ProjectMasterController::class, 'project_data'])->name('project_data');
Route::get('/ProjectGetData',[App\Http\Controllers\ProjectMasterController::class, 'ProjectGetData'])->name('ProjectGetData');
Route::get('/ProjectManagerData',[App\Http\Controllers\ProjectMasterController::class, 'ProjectManagerData'])->name('ProjectManagerData');
Route::get('/employee_data',[App\Http\Controllers\EmployeeMasterController::class, 'employee_data'])->name('employee_data');
