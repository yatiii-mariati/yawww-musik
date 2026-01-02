<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/ping', function () {
    return response()->json([
        'message' => 'API Yaww Musik Ready'
    ]);
});

Route::post('/login', [AuthController::class, 'login']);
