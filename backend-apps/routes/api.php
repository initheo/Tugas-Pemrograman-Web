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

    // Admin only routes
    Route::group(['middleware' => ['role:admin']], function () {
        // Endpoint Untuk Customer
        Route::resource('customers', App\Http\Controllers\API\CustomerController::class);
        // Additional customer route to get customer by user_id
        Route::get('customers/by-user/{userId}', [App\Http\Controllers\API\CustomerController::class, 'getByUserId']);

        // Endpoint Untuk Branch Store
        Route::resource('branchstores', App\Http\Controllers\API\BranchStoreController::class);

        // Endpoint Untuk Voucher
        Route::resource('vouchers', App\Http\Controllers\API\VoucherController::class);

        // Admin dashboard
        Route::get('/admin/dashboard', function () {
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
        })->name('admin.dashboard');

        // Admin can view all transactions and update laundry status
        Route::patch('transactions/{id}/laundry-status', [App\Http\Controllers\API\TransactionController::class, 'updateLaundryStatus']);
    });

    // User only routes
    Route::group(['middleware' => ['role:user']], function () {
        // User dashboard
        Route::get('/user/dashboard', [App\Http\Controllers\API\UserDashboardController::class, 'getDashboardStats']);
        Route::get('/user/transactions', [App\Http\Controllers\API\UserDashboardController::class, 'getUserTransactions']);
        Route::get('/user/vouchers', [App\Http\Controllers\API\UserDashboardController::class, 'getAvailableVouchers']);
        Route::get('/user/branches', [App\Http\Controllers\API\UserDashboardController::class, 'getAvailableBranches']);
        
        // User can get their own customer profile
        Route::get('/user/profile', [App\Http\Controllers\API\UserDashboardController::class, 'getUserProfile']);
    });

    // Shared routes (both admin and user)
    Route::resource('transactions', App\Http\Controllers\API\TransactionController::class);
    Route::get('transactions/{id}/payment-status', [App\Http\Controllers\API\TransactionController::class, 'checkPaymentStatus']);

    // Download Invoice
    Route::get('/transactions/{id}/download-invoice', [App\Http\Controllers\API\TransactionController::class, 'downloadInvoice']);

    // keep original dashboard for backward compatibility
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
