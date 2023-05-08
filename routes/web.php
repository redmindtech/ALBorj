<?php

use App\Http\Controllers\ClientMasterController;
use App\Http\Controllers\ItemMasterController;
use App\Http\Controllers\SupplierMasterController;
use App\Http\Controllers\SiteMasterController;
use App\Http\Controllers\ProjectMasterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ExpensesCategoryMasterController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\UserAuth;
use App\Http\Controllers\GoodsReceivingNoteController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
});

Route::get('registration', [RegistrationController::class, 'create'])->name('create');
Route::post('post-registration', [RegistrationController::class, 'postRegistration'])->name('register.post');

   Route::view('login', 'login');
   Route::get('main/main', [UserAuth::class, 'index']);
   Route::get('login', [UserAuth::class, 'index']);
   Route::post('/main/checklogin', [UserAuth::class,'checklogin']);
   Route::get('successlogin', [UserAuth::class,'successlogin']);
   Route::get('logout', [UserAuth::class,'logout']);

    Route::get('/home', function () {
        return view('home');
    })->name('home');

    Route::resource('itemmaster', 'ItemMasterController');
    Route::resource('clientmaster', 'ClientMasterController');
    Route::resource('projectmaster', 'ProjectMasterController');
    Route::resource('suppliermaster', 'SupplierMasterController');
    Route::resource('employeemaster', 'EmployeeMasterController');
    Route::resource('sitemaster', 'SiteMasterController');
    Route::resource('goodsreceivingnote', 'GoodsReceivingNoteController');
    Route::resource('expensescategorymaster', 'ExpensesCategoryMasterController');
    Route::resource('expenses', 'ExpensesController');
    Route::resource('goodsreceivingnote', 'GoodsReceivingNoteController');

    Route::get('/account', function () {
        return view('layouts.account');
    });
    Route::get('/timesheet', function () {
        return view('timesheet.index');
    });