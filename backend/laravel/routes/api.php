<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
define('API_BASE_URL', 'http://127.0.0.1:8000/api');
Route::get('/ping', function () {
    return response()->json([
        'message' => 'API Yaww Musik Ready'
    ]);
});

Route::post('/login', [AuthController::class, 'login']);
