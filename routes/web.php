<?php

use App\Exports\CustomersExport;
use App\Exports\LedgerExport;
use App\Http\Controllers\AdminController;
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
use App\Http\Controllers\FieldMeterController;
use App\Http\Controllers\FieldMeterReadingController;
use App\Http\Controllers\FieldMeterServicesController;
use App\Http\Controllers\NewConnectionController;
use App\Http\Controllers\MeterReaderController;
use App\Http\Controllers\ServiceListController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPasswordController;
use App\Http\Controllers\WaterBill;
use App\Services\CustomersFromKeyword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect(route('admin.dashboard'));
})->middleware('auth');


Route::get('/login',[LoginController::class,'index'])->name('login');
Route::post('/login',[LoginController::class,'authenticate']);


Route::prefix('admin')->middleware(['auth', 'auth.allowed-user'])->name('admin.')->group(function(){

    Route::resources([
        'searched-customers'=>SearchedCustomerController::class,
        'existing-customers'=>ExistingCustomerController::class,
        'new-connection' => NewConnectionController::class,
        'users'=>UserController::class,

    ]);
    Route::resource('user-passwords',UserPasswordController::class)->parameters([
        'user-passwords'=>'user'
    ]);



    Route::get('/service-list', [ServiceListController::class, 'index'])->name('services-list.index');

    // Export URLs
    Route::get('/customers/export/{keyword?}',[ExportsController::class,'exportCustomers'])->name('customers.export');
    Route::get('/ledger/export/{account_number}',[ExportsController::class,'exportLedger'])->name('ledger.export');


    Route::post('/logout',[LogoutUserController::class,'logout'])->middleware('auth')->name('logout');
    Route::get('/consumers',[CustomerController::class,'showAll'])->middleware('auth')->name('customers');
    Route::get('/transaction/new',[TransactionsController::class,'index'])->middleware('auth')->name('new-transaction');
    // Route::get('/register-consumer',[CustomerController::class,'index'])
    //     ->middleware('auth')
    //     ->name('register-customer');

    Route::post('/register-consumer',[CustomerController::class,'store'])
            ->middleware('access.authorize')->name('register-customer.store');

    Route::get('/dashboard',[DashboardController::class,'index'])
            ->middleware('access.authorize')
            ->name('dashboard');

    Route::get('/search-consumer',[CustomerSearchController::class,'search'])->name('search-customer');

    Route::get('/services/search',[ServiceController::class,'search'])->name('services.search');
    
    Route::resource('services', ServiceController::class);

    // RECONNECTION OF METER
    Route::get('reconnection',[ReconnectionController::class, 'index'])->name('reconnection');
    Route::get('search-consumer-info',[ReconnectionController::class, 'search'])->name('search');
    Route::post('reconnection/transaction/store',[ReconnectionController::class,'storeTransaction'])->name('reconnection.store');
    // END RECONNECTION OF METER

    // BUILDING INSPECTOR ALLOWED ACCESS ONLY
    Route::middleware('auth.allowed-bldg-inspector')->group(function(){
        Route::get('/bldg-area/request-approvals',[BLDGApprovalController::class, 'index'])->name('request-approvals');
        Route::get('/bldg-area/request-approvals/undo',[BLDGApprovalController::class, 'undo'])->name('undo');
        Route::post('/bldg-area/request-approvals/undo/{id}',[BLDGApprovalController::class, 'undoStatus'])->name('undo-status');
        Route::post('/bldg-area/request-approvals/approve',[BLDGApprovalController::class, 'approve'])->name('bld-request-approvals-approve');
        Route::post('/bldg-area/request-approvals/reject/{id}',[BLDGApprovalController::class, 'reject'])->name('bld-request-approvals-reject');
    });
    // END BUILDING INSPECTOR ALLOWED ACCESS ONLY

    // MUNICIPAL TREASURER OFFICE REQUEST APPROVALS
    Route::get('/mto/request-approvals',[MTOApprovalController::class, 'index'])->name('mto-request-approvals')->middleware('auth');
    Route::post('/mto/request-approvals/approve', [MTOApprovalController::class, 'approve'])->name('mto-request-approvals-approve');
    Route::post('/mto/request-approvals/reject', [MTOApprovalController::class, 'reject'])->name('mto-request-approvals-reject');
    // END MUNICIPAL TREASURER OFFICE REQUEST APPROVALS

    // WATER WORKS ALLOWED ACCESS ONLY
    Route::middleware('auth.allowed-waterworks-access')->group(function(){
        Route::get('/water-works/request-approvals',[WaterWorksApprovalController::class, 'index'])->name('waterworks-request-approvals');
        Route::post('/waterworks/request-approvals/approve', [WaterWorksApprovalController::class, 'approve'])->name('waterworks-request-approvals-approve');
        Route::post('/waterworks/request-approvals/reject/{id}', [WaterWorksApprovalController::class, 'reject'])->name('waterworks-request-approvals-reject');
    });
    // END WATER WORKS ALLOWED ACCESS ONLY

    // MUNICIPAL ENGINEER APPROVALS
    Route::get('/me/request-approvals',[MunicipalEngApprovalController::class, 'index'])->name('me-request-approvals')->middleware('auth');
    // END MUNICIPAL ENGINEER APPROVALS

    // TRANSACTION LISTS
    Route::get('/transactions-lists',[TransactionListsController::class, 'index'])->name('transactions-lists');
    // TRANSACTION LISTS

    // TRANSFER OF METER
    Route::get('/transfer-meter',[TransferOfMeterController::class, 'index'])->name('transfer-meter');
    Route::get('/search-info',[TransferOfMeterController::class, 'search'])->name('search-info');
    // END TRANSFER OF METER

    // ADMIN AND CASHIER ALLOWED ACCESS
    Route::middleware('auth.allowed-admin-cashier-access')->group(function(){
        // VIEWING AND SEARCHING OF EXISTING CUSTOMERS
            Route::resources([
                'searched-customers'=>SearchedCustomerController::class,
                'existing-customers'=>ExistingCustomerController::class,
                'new-connection' => NewConnectionController::class,
            ]);
        // END VIEWING AND SEARCHING OF EXISTING CUSTOMERS

        // CUSTOMER LEDGER
            Route::get('/consumer-ledger',[ConsumerLedgerController::class, 'index'])->name('consumer-ledger');
            Route::get('/consumer-ledger/transactions',[ConsumerLedgerController::class, 'search'])->name('search-transactions');
            Route::post('/consumer-ledger/transactions/save-billing',[ConsumerLedgerController::class,'store'])->name('save-billing');
            Route::post('/consumer-ledger/balance/payment/{id}',[PaymentController::class,'getBalance'])->name('get-balance');
            Route::post('/consumer-ledger/balance/payment/save/{id}',[PaymentController::class,'save_payment'])->name('save-payment');
            Route::post('/consumer-ledger/billing/transaction/{id}',[EditBillingController::class,'getBill'])->name('get-bill');
            Route::post('/consumer-ledger/billing/update/transaction',[EditBillingController::class,'updateBill'])->name('update-billing');
        // END CUSTOMER LEDGER
    });
    // ADMIN AND CASHIER ALLOWED ACCESS

    // ADMIN ALLOWED ACCESS ONLY
    Route::middleware('access.authorize')->group(function(){
        // CASHIER ACCOUNT CREATION
            Route::resource('cashiers',CashierController::class)->middleware('auth.restrict-cashier');
        // END CASHIER ACCOUNT CREATION

        // READER ACCOUNT CREATION
            Route::get('/meter-reader', [MeterReaderController::class, 'index'])->name('reader');
            Route::get('/meter-reader/create', [MeterReaderController::class, 'create'])->name('reader-create');
            Route::post('/meter-reader/store', [MeterReaderController::class, 'store'])->name('reader-store');
        // END READER ACCOUNT CREATION

        // ADMIN ACCOUNT CREATION
            Route::get('/new', [AdminController::class, 'index'])->name('admin');
            Route::get('/new/create', [AdminController::class, 'create'])->name('admin-create');
            Route::post('/new/store', [AdminController::class, 'store'])->name('admin-store');
        // END ADMIN ACCOUNT CREATION

        // WATER RATES AND SURCHARGE SETTINGS
            Route::get('/water-rate', [WaterRateController::class, 'getWaterRates'])->name('water-rate-get');
            Route::post('/water-rate', [WaterRateController::class, 'update'])->name('water-rate-update');
            Route::get('/surcharge', [SurchargeController::class, 'getSurcharge'])->name('surcharge-get');
            Route::post('/surcharge', [SurchargeController::class, 'update'])->name('surcharge-update');
        // END WATER RATES AND SURCHARGE SETTINGS
    });
    // END ADMIN ALLOWED ACCESS ONLY
});

Route::middleware('auth', 'auth.allowed-reader')->group(function(){

    Route::get('/field-personnel/home',[FieldMeterController::class, 'index'])->name('home');

    Route::get('/field-personnel/meter-reading',[FieldMeterReadingController::class, 'index'])->name('field-reading');
    Route::get('/field-personnel/meter-reading/search/consumer',[FieldMeterReadingController::class, 'search'])->name('search');
    Route::post('/field-personnel/meter-reading/save',[FieldMeterReadingController::class, 'store'])->name('save-meter-billing');

    Route::get('/field-personnel/meter-services',[FieldMeterServicesController::class, 'index'])->name('meter-services');
    Route::get('/field-personnel/meter-services/search/consumer',[FieldMeterServicesController::class, 'search'])->name('services-search-customer');
    Route::post('/field-personnel/meter-services',[FieldMeterServicesController::class, 'store'])->name('meter-services.store');

});

Route::post('/get/computed/water-bill',[WaterBill::class, 'computeWaterBill'])->name('water-bill');



