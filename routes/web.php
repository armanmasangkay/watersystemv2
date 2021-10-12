<?php

use App\Classes\Facades\Middleware\Allowed;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerSearchController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutUserController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\BLDGApprovalController;
use App\Http\Controllers\WaterWorksApprovalController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\WaterRateController;
use App\Http\Controllers\SurchargeController;
use App\Http\Controllers\ConsumerLedgerController;
use App\Http\Controllers\ExistingCustomerController;
use App\Http\Controllers\SearchedCustomerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\EditBillingController;
use App\Http\Controllers\EngineerController;
use App\Http\Controllers\ExportsController;
use App\Http\Controllers\FieldMeterController;
use App\Http\Controllers\FieldMeterReadingController;
use App\Http\Controllers\FieldMeterServicesController;
use App\Http\Controllers\NewConnectionController;
use App\Http\Controllers\MeterReaderController;
use App\Http\Controllers\OfficerController;
use App\Http\Controllers\RootController;
use App\Http\Controllers\ServicesPaymentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPasswordController;
use App\Http\Controllers\WaterBillController;
use App\Http\Controllers\WorkOrderController;
use App\Http\Controllers\WorkOrderPaymentsController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', [RootController::class,'index'])->middleware('auth'); // (Fully Tested)


Route::get('/login',[LoginController::class,'index'])->name('login'); // (Fully Tested)
Route::post('/login',[LoginController::class,'authenticate']); // (Fully Tested)

Route::middleware('auth')->group(function(){
    Route::get('/users/change-password', [UserController::class, 'updatePassword'])->name('users.update-password.edit'); // (Fully Tested)
    Route::put('/users/change-password', [UserController::class, 'storeNewPassword'])->name('users.update-password.store'); // (Fully Tested)
});

Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function(){


    Route::resources([
        'searched-customers'=>SearchedCustomerController::class, // (Fully Tested)
        'existing-customers'=>ExistingCustomerController::class, // (Fully Tested)
        'new-connection' => NewConnectionController::class, // (Fully Tested)

    ]);

    // Export URLs
    Route::get('/customers/export/{keyword?}',[ExportsController::class,'exportCustomers'])->name('customers.export'); // (Fully Tested)
    Route::get('/ledger/export/{account_number}',[ExportsController::class,'exportLedger'])->name('ledger.export'); // (Fully Tested)


   
    Route::get('/transaction/new',[TransactionsController::class,'index'])->middleware('auth')->name('new-transaction');

    Route::get('/search-consumer',[CustomerSearchController::class,'search'])->name('search-customer');

    // BUILDING INSPECTOR ALLOWED ACCESS ONLY
    Route::middleware(Allowed::role(User::$BLDG_INSPECTOR))->group(function(){
        Route::get('/bldg-area/request-approvals',[BLDGApprovalController::class, 'index'])->name('request-approvals');
        Route::get('/bldg-area/request-approvals/undo',[BLDGApprovalController::class, 'undo'])->name('undo');
        Route::get('/bldg-area/request-approvals/search',[BLDGApprovalController::class, 'search'])->name('search');
        Route::post('/bldg-area/request-approvals/undo/{id}',[BLDGApprovalController::class, 'undoStatus'])->name('undo-status');
        Route::get('/bldg-area/request-approvals/search-denied',[BLDGApprovalController::class,'search_denied'])->name('search.denied');
        Route::post('/bldg-area/request-approvals/approve',[BLDGApprovalController::class, 'approve'])->name('bld-request-approvals-approve');
        Route::post('/bldg-area/request-approvals/reject/{id}',[BLDGApprovalController::class, 'reject'])->name('bld-request-approvals-reject');
    });
    // END BUILDING INSPECTOR ALLOWED ACCESS ONLY


    // WATER WORKS ALLOWED ACCESS ONLY
    Route::middleware(Allowed::role(User::$WATERWORKS_INSPECTOR))->group(function(){
        Route::get('/water-works/request-approvals/search',[WaterWorksApprovalController::class, 'search'])->name('water.search');
        // Route::get('/water-works/request-approvals/search-denied',[WaterWorksApprovalController::class,'search_denied'])->name('water.search.denied');
        Route::get('/water-works/request-approvals',[WaterWorksApprovalController::class, 'index'])->name('waterworks-request-approvals');
        Route::post('/waterworks/request-approvals/approve', [WaterWorksApprovalController::class, 'approve'])->name('waterworks-request-approvals-approve');
        Route::post('/waterworks/request-approvals/reject/{id}', [WaterWorksApprovalController::class, 'reject'])->name('waterworks-request-approvals-reject');
        Route::get('/waterworks/pending-completion', [WaterWorksApprovalController::class, 'pendingForCompletion'])->name('waterworks.pending-for-completion');
        Route::get('/waterworks/pending-completion/done/{service}', [WaterWorksApprovalController::class, 'markAsDone'])->name('waterworks.pending-for-completion.mark');
    });
    // END WATER WORKS ALLOWED ACCESS ONLY

    // MUNICIPAL ENGINEER
    Route::middleware(Allowed::role(User::$ENGINEER))->group(function(){

        Route::get('/engineer/index',[EngineerController::class, 'index'])->name('municipal-engineer.index');
        Route::get('/engineer/search',[EngineerController::class, 'search'])->name('municipal-engineer.search');
        Route::post('/engineer/approve',[EngineerController::class, 'approve'])->name('municipal-engineer.approve');
        Route::post('/engineer/deny',[EngineerController::class, 'deny'])->name('municipal-engineer.deny');


    });
    // END MUNICIPAL ENGINEER


    // ADMIN AND CASHIER ALLOWED ACCESS
    Route::middleware(Allowed::role(User::$ADMIN, User::$CASHIER))->group(function(){
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

            Route::get('/work-order/payments',[WorkOrderPaymentsController::class,'index'])->name('work-order.payments.index');

    });
    // ADMIN AND CASHIER ALLOWED ACCESS

    // CASHIER ALLOWED ACCESS ONLY
    Route::middleware(Allowed::role(User::$CASHIER))->group(function(){
        // SERVICES PAYMEN
            Route::get('/services-for-payment',[ServicesPaymentController::class, 'index'])->name('services-payment');
            Route::get('/services-for-payment/search',[ServicesPaymentController::class, 'search'])->name('services-payment-search');
            Route::post('/services-for-payment/work-order',[ServicesPaymentController::class, 'savePayment'])->name('services-payment-save');
        // END SERVICES PAYMENT
    });
    // END CASHIER ALLOWED ACCESS ONLY



    // ADMIN ALLOWED ACCESS ONLY
    Route::middleware(Allowed::role(User::$ADMIN))->group(function(){

        // SERVICES
        Route::resource('users',UserController::class);
        Route::resource('officers', OfficerController::class);
        Route::resource('user-passwords',UserPasswordController::class)->parameters([
            'user-passwords'=>'user'
        ]);

        // END SERVICES

        Route::get('/consumers',[CustomerController::class,'showAll'])->middleware('auth')->name('customers'); // fully tested

        // READER ACCOUNT CREATION
            Route::get('/meter-reader', [MeterReaderController::class, 'index'])->name('reader');
            Route::get('/meter-reader/create', [MeterReaderController::class, 'create'])->name('reader-create');
            Route::post('/meter-reader/store', [MeterReaderController::class, 'store'])->name('reader-store');
        // END READER ACCOUNT CREATION

        // WATER RATES AND SURCHARGE SETTINGS
            Route::get('/water-rate', [WaterRateController::class, 'getWaterRates'])->name('water-rate-get');
            Route::post('/water-rate', [WaterRateController::class, 'update'])->name('water-rate-update');
            Route::get('/surcharge', [SurchargeController::class, 'getSurcharge'])->name('surcharge-get');
            Route::post('/surcharge', [SurchargeController::class, 'update'])->name('surcharge-update');
        // END WATER RATES AND SURCHARGE SETTINGS

        Route::get('/services/search',[ServiceController::class,'search'])->name('services.search');
        Route::get('/services/filter',[ServiceController::class,'filter'])->name('services.filter');
        Route::resource('services', ServiceController::class);

        Route::post('/register-consumer',[CustomerController::class,'store'])->name('register-customer.store');

        Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');

        Route::get('/work-order',[WorkOrderController::class,'index'])->name('workorder');
        Route::get('/work-order/filter',[WorkOrderController::class,'filter'])->name('workorder.filter');
        
    });
    // END ADMIN ALLOWED ACCESS ONLY

    // FIELD METER USER ACCESS ONLY
    Route::middleware(Allowed::role(User::$READER))->group(function(){

        Route::get('/field-personnel/home',[FieldMeterController::class, 'index'])->name('home');

        Route::get('/field-personnel/meter-reading',[FieldMeterReadingController::class, 'index'])->name('field-reading');
        Route::get('/field-personnel/meter-reading/search/consumer',[FieldMeterReadingController::class, 'search'])->name('reader.search');
        Route::post('/field-personnel/meter-reading/save',[FieldMeterReadingController::class, 'store'])->name('save-meter-billing');

        Route::get('/field-personnel/meter-services',[FieldMeterServicesController::class, 'index'])->name('meter-services');
        Route::get('/field-personnel/meter-services/search/consumer',[FieldMeterServicesController::class, 'search'])->name('services-search-customer');
        Route::post('/field-personnel/meter-services',[FieldMeterServicesController::class, 'store'])->name('meter-services.store');

    });
    // END FIELD METER USER ACCESS ONLY

});

Route::post('/logout',[LogoutUserController::class,'logout'])->middleware('auth')->name('logout');

Route::post('/get/computed/water-bill',[WaterBillController::class, 'computeWaterBill'])->name('water-bill');
