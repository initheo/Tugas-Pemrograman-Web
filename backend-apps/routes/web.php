<?php

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ExportController;

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
 
Route::get('/', function(){

    return response()->json([
        'message' => 'Welcome to the API'
    ]);

})->name('index');


// make handle route /api/payment/callback
Route::post('/api/payment/callback', [App\Http\Controllers\API\TransactionController::class, 'paymentCallback'])
    ->name('payment.callback');

Route::get('/unauthenticated', function () {
    
    return response()->json([
        'message' => 'You are not authenticated'
    ], 401);

})->name('unauthenticated');