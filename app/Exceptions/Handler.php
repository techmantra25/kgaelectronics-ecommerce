<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        // Handle API or admin routes
        if ($request->is('api/*') || $request->is('admin/*') || $request->expectsJson()) {

            if ($exception instanceof ModelNotFoundException) {
                return response()->json([
                    'status' => false,
                    'message' => 'Resource item not found.'
                ], 404);
            }

            if ($exception instanceof NotFoundHttpException) {
                return response()->json([
                    'status' => false,
                    'message' => 'Resource not found.'
                ], 404);
            }

            if ($exception instanceof MethodNotAllowedHttpException) {
                return response()->json([
                    'status' => false,
                    'message' => 'Method not allowed.'
                ], 405);
            }

            // Fallback for other exceptions
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage() ?: 'Server Error'
            ], method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500);
        }

        // For web routes, use Laravel default
        return parent::render($request, $exception);
    }
}
