<?php

use App\Exports\CustomersExport;
use App\Exports\LedgerExport;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerSearchController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutUserController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\ReconnectionController;
use App\Http\Controllers\BLDGApprovalController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\MTOApprovalController;
use App\Http\Controllers\WaterWorksApprovalController;
use App\Http\Controllers\MunicipalEngApprovalController;
use App\Http\Controllers\ReconnectionTransactionController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TransactionListsController;
use App\Http\Controllers\TransferOfMeterController;
use App\Http\Controllers\WaterRateController;
use App\Http\Controllers\SurchargeController;
use App\Http\Controllers\ConsumerLedgerController;
use App\Http\Controllers\ExistingCustomerController;
use App\Http\Controllers\SearchedCustomerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\EditBillingController;
use App\Http\Controllers\ExportsController;
use App\Services\CustomersFromKeyword;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect(route('admin.dashboard'));
})->middleware('auth');


Route::get('/login',[LoginController::class,'index'])->name('login');
Route::post('/login',[LoginController::class,'authenticate']);




Route::prefix('admin')->middleware('auth')->name('admin.')->group(function(){

    Route::resources([
        'searched-customers'=>SearchedCustomerController::class,
        'existing-customers'=>ExistingCustomerController::class,

    ]);


    // Export URLs
    Route::get('/customers/export/{keyword?}',[ExportsController::class,'exportCustomers'])->name('customers.export');
    Route::get('/ledger/export/{account_number}',[ExportsController::class,'exportLedger'])->name('ledger.export');


    Route::resource('cashiers',CashierController::class)->middleware('auth.restrict-cashier');
    Route::post('/logout',[LogoutUserController::class,'logout'])->middleware('auth')->name('logout');
    Route::get('/consumers',[CustomerController::class,'showAll'])->middleware('auth')->name('customers');
    Route::get('/transaction/new',[TransactionsController::class,'index'])->middleware('auth')->name('new-transaction');
    Route::get('/register-consumer',[CustomerController::class,'index'])
        ->middleware('auth')
        ->name('register-customer');

    Route::post('/register-consumer',[CustomerController::class,'store'])
            ->middleware('access.authorize')->name('register-customer.store');
    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard')->middleware('auth.restrict-cashier');

    Route::get('/search-consumer',[CustomerSearchController::class,'search'])->name('search-customer');


    Route::resource('services', ServiceController::class);

    Route::get('reconnection',[ReconnectionController::class, 'index'])->name('reconnection');
    Route::get('search-consumer-info',[ReconnectionController::class, 'search'])->name('search');
    Route::post('reconnection/transaction/store',[ReconnectionController::class,'storeTransaction'])->name('reconnection.store');

    Route::get('/bldg-area/request-approvals',[BLDGApprovalController::class, 'index'])->name('request-approvals')->middleware('auth');
    Route::post('/bldg-area/request-approvals/approve',[BLDGApprovalController::class, 'approve'])->name('bld-request-approvals-approve');
    Route::post('/bldg-area/request-approvals/reject/{id}',[BLDGApprovalController::class, 'reject'])->name('bld-request-approvals-reject');

    Route::get('/mto/request-approvals',[MTOApprovalController::class, 'index'])->name('mto-request-approvals')->middleware('auth');
    Route::post('/mto/request-approvals/approve', [MTOApprovalController::class, 'approve'])->name('mto-request-approvals-approve');
    Route::post('/mto/request-approvals/reject', [MTOApprovalController::class, 'reject'])->name('mto-request-approvals-reject');

    Route::get('/water-works/request-approvals',[WaterWorksApprovalController::class, 'index'])->name('waterworks-request-approvals')->middleware('auth');
    Route::post('/waterworks/request-approvals/approve', [WaterWorksApprovalController::class, 'approve'])->name('waterworks-request-approvals-approve');
    Route::post('/waterworks/request-approvals/reject/{id}', [WaterWorksApprovalController::class, 'reject'])->name('waterworks-request-approvals-reject');

    Route::get('/me/request-approvals',[MunicipalEngApprovalController::class, 'index'])->name('me-request-approvals')->middleware('auth');

    Route::get('/transactions-lists',[TransactionListsController::class, 'index'])->name('transactions-lists');

    Route::get('/transfer-meter',[TransferOfMeterController::class, 'index'])->name('transfer-meter');
    Route::get('/search-info',[TransferOfMeterController::class, 'search'])->name('search-info');

    Route::get('/water-rate', [WaterRateController::class, 'getWaterRates'])->middleware('access.authorize')->name('water-rate-get');
    Route::post('/water-rate', [WaterRateController::class, 'update'])->name('water-rate-update');
    Route::get('/surcharge', [SurchargeController::class, 'getSurcharge'])->middleware('access.authorize')->name('surcharge-get');
    Route::post('/surcharge', [SurchargeController::class, 'update'])->name('surcharge-update');

    Route::get('/transaction/update/{account_id}/{id}', [TransactionController::class, 'edit']);
    Route::get('/consumer-ledger',[ConsumerLedgerController::class, 'index'])->name('consumer-ledger');
    Route::get('/consumer-ledger/transactions',[ConsumerLedgerController::class, 'search'])->name('search-transactions');
    Route::post('/consumer-ledger/transactions/save-billing',[ConsumerLedgerController::class,'store'])->middleware('access.authorize')->name('save-billing');

    Route::post('/consumer-ledger/balance/payment/{id}',[PaymentController::class,'getBalance'])->middleware('access.authorize')->name('get-balance');
    Route::post('/consumer-ledger/balance/payment/save/{id}',[PaymentController::class,'save_payment'])->middleware('access.authorize')->name('save-payment');

    Route::post('/consumer-ledger/billing/transaction/{id}',[EditBillingController::class,'getBill'])->middleware('access.authorize')->name('get-bill');
    Route::post('/consumer-ledger/billing/transaction/update/{id}',[EditBillingController::class,'updateBill'])->middleware('access.authorize')->name('update-billing');
});




