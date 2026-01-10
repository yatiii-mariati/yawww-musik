<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class ActivityLogger
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $userId = null;

        if ($request->hasHeader('Authorization')) {
            try {
                $user = JWTAuth::parseToken()->authenticate();
                $userId = $user?->id;
            } catch (\Exception $e) {
                $userId = null;
            }
        }

        DB::table('activity_logs')->insert([
            'user_id'     => $userId,
            'action'      => $request->method(),
            'model'       => null,
            'model_id'    => null,
            'description' => $request->fullUrl(),
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return $response;
    }
}
