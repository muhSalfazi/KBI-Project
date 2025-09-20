<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    public function render($request, Throwable $exception)
    {
        // Menangani pengecualian HTTP
        if ($this->isHttpException($exception)) {
            if ($exception->getStatusCode() == 404) {
                // Periksa role pengguna
                if (auth()->check()) {
                    $role = auth()->user()->role;
        
                    if (in_array($role, ['admin', 'viewer'])) {
                        return response()->view('errors.404', [], 404);
                    }
        
                    if ($role === 'user') {
                        return response()->view('errors.404-user', [], 404);
                    }
                }
        
                // Untuk guest
                return response()->view('errors.404-user', [], 404);
            }
        }
        

          // Jika permintaan berasal dari API, kembalikan respons JSON
         if ($request->is('api/*')) {
        return response()->json([
            'success' => false,
            'message' => $exception->getMessage(),
        ], 500);
    }
        // Untuk pengecualian lainnya
        return parent::render($request, $exception);
    }

}