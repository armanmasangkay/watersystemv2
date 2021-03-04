<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutUserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect(route('admin.dashboard'));
})->middleware('auth');


Route::get('/login',[LoginController::class,'index'])->name('login');
Route::post('/login',[LoginController::class,'authenticate']);

Route::prefix('admin')->name('admin.')->group(function(){

    Route::post('/logout',[LogoutUserController::class,'logout'])->middleware('auth')->name('logout');
    Route::get('/customers',[CustomerController::class,'showAll'])->middleware('auth')->name('customers');
    
    Route::get('/register-customer',[CustomerController::class,'index'])
        ->middleware('auth')
        ->name('register-customer');

    Route::post('/register-customer',[CustomerController::class,'store'])
            ->middleware('access.authorize');

    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');

});


 
