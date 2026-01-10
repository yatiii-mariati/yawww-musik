<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Auth\AuthenticationException;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        if ($request->is('api/*')) {
            return null;
        }

        return route('login');
    }

    public function handle($request, \Closure $next, ...$guards)
    {
        try {

            return parent::handle($request, $next, ...$guards);

        } catch (AuthenticationException $e) {

            // Tentukan error message sesuai kondisi token
            $message = "Silakan login terlebih dahulu";

            if (!$request->hasHeader('Authorization')) {
                $message = "Header Authorization tidak ditemukan";
            } else {
                $message = "Token tidak valid atau sudah kadaluwarsa";
            }

            return response()->json([
                "code" => 401,
                "message" => $message,
                "data" => []
            ], 401);
        }
    }
}
