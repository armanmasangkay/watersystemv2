<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerSearchController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutUserController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\ReconnectionController;
use App\Http\Controllers\BLDGApprovalController;
use App\Http\Controllers\MTOApprovalController;
use App\Http\Controllers\WaterWorksApprovalController;
use App\Http\Controllers\MunicipalEngApprovalController;
use App\Http\Controllers\TransactionListsController;
use App\Http\Controllers\TransferOfMeterController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect(route('admin.dashboard'));
})->middleware('auth');


Route::get('/login',[LoginController::class,'index'])->name('login');
Route::post('/login',[LoginController::class,'authenticate']);

Route::prefix('admin')->name('admin.')->group(function(){

    Route::post('/logout',[LogoutUserController::class,'logout'])->middleware('auth')->name('logout');
    Route::get('/customers',[CustomerController::class,'showAll'])->middleware('auth')->name('customers');
    Route::get('/transaction/new',[TransactionsController::class,'index'])->middleware('auth')->name('new-transaction');
    Route::get('/register-customer',[CustomerController::class,'index'])
        ->middleware('auth')
        ->name('register-customer');

    Route::post('/register-customer',[CustomerController::class,'store'])
            ->middleware('access.authorize');
    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');

    Route::get('/search-customer',[CustomerSearchController::class,'search'])->name('search-customer');

    Route::resource('transactions',TransactionController::class)->middleware('auth');

    Route::get('re-connection',[ReconnectionController::class, 'index'])->name('reconnection');
    Route::get('search-customer-info',[ReconnectionController::class, 'search'])->name('search');

    Route::get('/bldg-area/request-approvals',[BLDGApprovalController::class, 'index'])->name('request-approvals')->middleware('auth');

    Route::get('/MTO/request-approvals',[MTOApprovalController::class, 'index'])->name('mto-request-approvals')->middleware('auth');

    Route::get('/water-works/request-approvals',[WaterWorksApprovalController::class, 'index'])->name('waterworks-request-approvals')->middleware('auth');

    Route::get('/ME/request-approvals',[MunicipalEngApprovalController::class, 'index'])->name('me-request-approvals')->middleware('auth');

    Route::get('/transactions-lists',[TransactionListsController::class, 'index'])->name('transactions-lists');

    Route::get('/transfer-meter',[TransferOfMeterController::class, 'index'])->name('transfer-meter');
    Route::get('/search-info',[TransferOfMeterController::class, 'search'])->name('search-info');
});



 
