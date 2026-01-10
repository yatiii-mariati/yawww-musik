<?php

use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

if (!function_exists('activity_log')) {
    function activity_log(string $action, string $model = null, string $description = null, $modelId = null)
    {
        $userId = null;

        try {
            if (JWTAuth::getToken()) {
                $user = JWTAuth::parseToken()->authenticate();
                $userId = $user?->id;
            }
        } catch (\Exception $e) {
            // login / register TIDAK punya token → aman
        }

        DB::table('activity_logs')->insert([
            'user_id'     => $userId,
            'action'      => $action,
            'model'       => $model,
            'model_id'    => $modelId,
            'description' => $description,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
    }
}
