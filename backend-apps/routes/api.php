<?php

use App\Http\Controllers\API\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PegawaiController;


Route::post('login', [ApiController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () { 
   
    Route::post('/logout', [ApiController::class, 'logout']);
    
    // Profile routes
    Route::put('/profile', [ApiController::class, 'updateProfile']);
    Route::put('/change-password', [ApiController::class, 'changePassword']);

    // Endpoint Untuk Customer
     Route::resource('customers', App\Http\Controllers\API\CustomerController::class);

     // Endpoint Untuk Branch Store
    Route::resource('branchstores', App\Http\Controllers\API\BranchStoreController::class);

    // Endpoint Untuk Voucher
    Route::resource('vouchers', App\Http\Controllers\API\VoucherController::class);

});
