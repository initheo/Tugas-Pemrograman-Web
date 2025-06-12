<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

// Route not used ajax
Route::resource('kontaks', KontakController::class); 
Route::resource('users', UserController::class);
Route::resource('events', EventController::class);
Route::resource('employees', EmployeeController::class);
Route::resource('tokos', TokoController::class);
Route::resource('produks', ProdukController::class); 