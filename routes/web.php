<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\HobiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SongController;
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

// Route used ajax
Route::resource('films', FilmController::class);
Route::resource('notes', NoteController::class);
Route::resource('books', BookController::class);
Route::resource('songs', SongController::class);
 
 
Route::resource('hobis', HobiController::class);

