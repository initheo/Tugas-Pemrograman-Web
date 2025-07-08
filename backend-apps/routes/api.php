<?php

use App\Models\Customer;
use App\Models\BranchStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApiController;
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

    // Endpoint untuk Transactions
    Route::resource('transactions', App\Http\Controllers\API\TransactionController::class);
    Route::get('transactions/{id}/payment-status', [App\Http\Controllers\API\TransactionController::class, 'checkPaymentStatus']);
    Route::patch('transactions/{id}/laundry-status', [App\Http\Controllers\API\TransactionController::class, 'updateLaundryStatus']);

    // Download Invoice
    Route::post('/transactions/{id}/download-invoice', [App\Http\Controllers\API\TransactionController::class, 'downloadInvoice']);

    // handle insight dashboard route
    Route::get('/dashboard', function () {

        // Total Customers
        $totalCustomers = Customer::count();
        // Total Branches
        $totalBranches = BranchStore::count();
        // Active Vouchers where now() < end_date
        $activeVouchers = \App\Models\Voucher::where('valid_until', '>', now())
            ->count();

        // get 5 The Best Customer
        $bestCustomers = Customer::withSum('transactions', 'total_amount')
            ->orderBy('transactions_sum_total_amount', 'desc')
            ->take(5)
            ->get();

        // get 5 The Best Branch Shop
        $bestBranches =  BranchStore::withSum('transactions', 'total_amount')
            ->orderBy('transactions_sum_total_amount', 'desc')
            ->take(5)
            ->get();

        // return json
        return response()->json([
            'total_customers' => $totalCustomers,
            'total_branches' => $totalBranches,
            'active_vouchers' => $activeVouchers,
            'best_customers' => $bestCustomers,
            'best_branches' => $bestBranches,
        ]);
        
    })->name('dashboard.index');

    
});

// Payment callback (tidak perlu auth)
Route::post('payment/callback', [App\Http\Controllers\API\TransactionController::class, 'paymentCallback']);
