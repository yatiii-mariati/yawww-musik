<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        activity_log(
            'REGISTER',
            'AUTH',
            'User mendaftar akun baru: ' . $user->email
        );

        return response()->json([
            'success' => true,
            'message' => 'Register success',
            'data' => $user
        ], 201);
    }

    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    if (! $token = JWTAuth::attempt($credentials)) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials'
        ], 401);
    }

    // 🔥 AMBIL USER DARI TOKEN
    $user = JWTAuth::setToken($token)->authenticate();

    activity_log(
        'LOGIN',
        'AUTH',
        'User berhasil login: ' . $user->email
    );

    return response()->json([
        'success'    => true,
        'token'      => $token,
        'token_type' => 'bearer'
    ]);
}


    public function me()
    {
        return response()->json([
            'success' => true,
            'data' => JWTAuth::user()
        ]);
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        activity_log(
            'LOGOUT',
            'AUTH',
            'User logout'
        );

        return response()->json([
            'success' => true,
            'message' => 'Logout success'
        ]);
    }
}
