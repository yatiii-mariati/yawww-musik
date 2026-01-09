<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('frontend.welcome');
});

/*
|--------------------------------------------------------------------------
| Auth Routes (WEB)
|--------------------------------------------------------------------------
*/
Route::get('/login', function () {
    return view('frontend.login');
})->name('login');

Route::get('/register', function () {
    return view('frontend.register');
});

Route::post('/login', [AuthController::class, 'loginWeb']);
Route::post('/register', [AuthController::class, 'registerWeb']);
Route::post('/logout', [AuthController::class, 'logoutWeb']);

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('frontend.dashboard');
    });

    Route::get('/top10', function () {
        return view('frontend.top10');
    });

    Route::get('/recommendation', function () {
        return view('frontend.recommendation');
    });

    Route::get('/favorite', function () {
        return view('frontend.favorite');
    });

});
