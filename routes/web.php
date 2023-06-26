<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('auth.login');
});
// Route::get('/blank', function () {
//     return view('blank');
// });

Auth::routes();

Route::get('/blank', [App\Http\Controllers\HomeController::class, 'blank'])->name('blank');

// Google login
Route::get('login/google', [App\Http\Controllers\Auth\LoginController::class, 'redirectToGoogle'])->name('google.login');
Route::get('login/google/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleGoogleCallback']);

Route::group(['middleware' => ['auth','admin']], function () {
    // admin Routs
    Route::group(['prefix' => 'admin'], function() {
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home.admin');
        // Route::controller(CheckoutController::class)->group(function () {
            
        // });
    });
});

Route::group(['middleware' => ['auth','employee']], function () {
    // employee Routs
    Route::group(['prefix' => 'employee'], function() {
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'indexEmployee'])->name('home.employee');
        // Route::controller(CheckoutController::class)->group(function () {
            
        // });
    });
});