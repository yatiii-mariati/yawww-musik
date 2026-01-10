<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\LogModel;
use App\Helpers\ApiFormatter;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth; // optional, jika pakai tymon/jwt-auth
use Exception;

class LogAPI
{
    /**
     * Handle an incoming request.
     *
     * We capture request and response (safe-filtered), user id if available, route, ip, user agent, and status code.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // capture request data (filter sensitive)
        $requestData = $request->all();
        $requestData = ApiFormatter::filterSensitiveData($requestData);

        // try to get user id safely
        $userId = null;
        try {
            // Attempt to get authenticated user (works if JWT or any auth guard is set)
            if (auth()->check()) {
                $user = auth()->user();
                $userId = $user ? $user->id : null;
            } else {
                // if using tymon/jwt-auth and token present
                if ($request->bearerToken() && class_exists('\Tymon\JWTAuth\Facades\JWTAuth')) {
                    try {
                        $jwtUser = JWTAuth::parseToken()->authenticate();
                        $userId = $jwtUser ? $jwtUser->id : null;
                    } catch (Exception $e) {
                        // ignore, token invalid or not parsed
                    }
                }
            }
        } catch (Exception $e) {
            $userId = null;
        }

        // Proceed request and capture response
        /** @var Response $response */
        $response = $next($request);

        // prepare response content
        $responseContent = null;
        try {
            $content = $response->getContent();
            // try decode json
            $decoded = json_decode($content, true);
            $responseContent = $decoded !== null ? $decoded : ['raw' => mb_substr($content, 0, 2000)];
        } catch (\Throwable $e) {
            $responseContent = ['raw' => 'unable_to_capture_response'];
        }

        // Create log entry (safe)
        try {
            LogModel::create([
                'method' => $request->method(),
                'route' => $request->path(),
                'ip_address' => $request->ip(),
                'user_id' => $userId,
                'user_agent' => substr($request->header('user-agent') ?? '', 0, 1000),
                'request' => $requestData,
                'response' => ApiFormatter::filterSensitiveData(is_array($responseContent) ? $responseContent : ['data' => $responseContent]),
                'status_code' => $response->getStatusCode(),
                'message' => null,
            ]);
        } catch (\Throwable $e) {
            // jangan lempar error logging, biarkan request tetap berjalan
        }

        return $response;
    }
}
