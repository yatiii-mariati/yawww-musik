<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * REGISTER USER
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'role'     => 'user',
        ]);

        activity_log(
            'REGISTER',
            'AUTH',
            'User mendaftar akun baru: ' . $user->email
        );

        return response()->json([
            'success' => true,
            'message' => 'Register success',
            'data'    => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
            ]
        ], 201);
    }

    /**
     * LOGIN USER
     */
    public function login(Request $request)
{
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user) {
        return response()->json([
            'success' => false,
            'message' => 'Email tidak terdaftar'
        ], 404);
    }

    if (! $token = JWTAuth::attempt([
        'email'    => $request->email,
        'password' => $request->password
    ])) {
        return response()->json([
            'success' => false,
            'message' => 'Password salah'
        ], 401);
    }

    activity_log(
        'LOGIN',
        'AUTH',
        'User berhasil login: ' . $user->email
    );

    return response()->json([
        'success'    => true,
        'message'    => 'Login success',
        'token'      => $token,
        'token_type' => 'bearer',
        'user'       => [
            'id'    => $user->id,
            'name'  => $user->name,
            'email' => $user->email,
            'role'  => $user->role,
        ]
    ]);
}


    /**
     * GET CURRENT USER
     */
    public function me()
    {
        return response()->json([
            'success' => true,
            'data'    => JWTAuth::user()
        ]);
    }

    /**
     * LOGOUT USER
     */
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
