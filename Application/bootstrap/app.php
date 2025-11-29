<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\ErrorHandler\Error\FatalError;
use Illuminate\Http\Client\ConnectionException as HttpConnectionException;
use Illuminate\Http\Client\RequestException as HttpRequestException;
use Illuminate\Database\QueryException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Render friendly messages for fatal errors and connectivity/timeouts
        $exceptions->render(function (\Throwable $e, $request) {
            $message = null;
            $status = 500;

            // Max execution time or FatalError
            if ($e instanceof FatalError || (stripos($e->getMessage(), 'Maximum execution time') !== false)) {
                $message = 'Permintaan membutuhkan waktu terlalu lama untuk diproses. Silakan coba lagi beberapa saat.';
                $status = 504;
            }

            // HTTP client connectivity (e.g., storage bad gateway/timeout)
            if (!$message && ($e instanceof HttpConnectionException || $e instanceof HttpRequestException)) {
                $message = 'Layanan eksternal sedang tidak dapat diakses atau lambat (Bad Gateway/Timeout). Silakan coba lagi beberapa saat.';
                $status = 502;
            }

            // Database connectivity/traffic
            if (!$message && $e instanceof QueryException) {
                $message = 'Server database sedang sibuk atau tidak dapat diakses. Error: ' . $e->getMessage();
                $status = 503;
            }

            if ($message) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => $message], $status);
                }
                return response($message, $status);
            }

            return null; // use default rendering
        });
    })->create();
