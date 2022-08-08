<?php

use App\Http\Controllers\GigController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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


Route::get('/', [GigController::class, 'index']);

// AUTHENTICATED ROUTES
Route::middleware('auth')->group(function () {
    Route::get('/gigs/create', [GigController::class, 'create']);

    Route::post('/gigs', [GigController::class, 'store']);

    Route::get('/gigs/{gig}/edit', [GigController::class, 'edit']);

    Route::put('/gigs/{gig}/', [GigController::class, 'update']);

    Route::delete('/gigs/{gig}/', [GigController::class, 'destroy']);

    // Manage Gigs
    Route::get("/gigs/manage", [GigController::class, 'manage']);
});

Route::get('/gigs/{gig}', [GigController::class, 'show']);




// GUEST ROUTES
Route::middleware('guest')->group(function () {

    // SHOW REGISTER FORM
    Route::get('/register', [UserController::class, 'register']);
    
    // Show login form
    Route::get('/login', [UserController::class, 'login'])->name('login');
});


Route::post('/users', [UserController::class, 'store']);

Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::post('/users/authenticate', [UserController::class, 'authenticate']);