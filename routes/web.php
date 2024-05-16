<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth']) -> group(function () {
    Route::get('/listings/create', [ListingController::class, 'create']);
    Route::post('/listings', [ListingController::class, 'store']);
    Route::get('/listings/{listing}/edit', [ListingController::class, 'edit']);
    Route::put('/listings/{listing}', [ListingController::class, 'update']);
    Route::get('/listings/manage', [ListingController::class, 'manage']);
    Route::delete('/listings/{listing}', [ListingController::class, 'destroy']);
    Route::post('/logout', [UserController::class, 'logout']);
});

Route::middleware(['guest']) -> group(function () {
    Route::get('/register', [UserController::class, 'create']);
    Route::post('/register', [UserController::class, 'store']);
    Route::get('/login', [UserController::class, 'login']) -> name('login');
    Route::post('/login', [UserController::class, 'authenticate']);
});

Route::get('/', [ListingController::class, 'index']);
Route::get('/listings/{listing}', [ListingController::class, 'show']);
