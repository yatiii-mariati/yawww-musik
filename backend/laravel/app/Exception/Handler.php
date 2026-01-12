<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        //
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $e)
    {
        // =====================================
        // RESPONSE KHUSUS JSON / API
        // =====================================
        if ($request->expectsJson()) {

            // ❌ VALIDATION ERROR
            if ($e instanceof ValidationException) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Validasi gagal',
                    'errors'  => $e->errors(),
                ], 422);
            }

            // ❌ AUTH ERROR (TOKEN / LOGIN)
            if ($e instanceof AuthenticationException) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Unauthenticated',
                ], 401);
            }

            // ❌ HTTP ERROR (403, 404, dll)
            if ($e instanceof HttpException) {
                return response()->json([
                    'status'  => false,
                    'message' => $e->getMessage() ?: 'Request error',
                ], $e->getStatusCode());
            }

            // ❌ SERVER ERROR (500)
            return response()->json([
                'status'  => false,
                'message' => 'Server error',
                'error'   => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }

        // =====================================
        // DEFAULT RESPONSE (WEB / BLADE)
        // =====================================
        return parent::render($request, $e);
    }
}
