<?php

namespace App\Exceptions;

use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Throwable;
use Exception;

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
    protected function unauthenticated($request, \Illuminate\Auth\AuthenticationException $exception)
    {
        // Jika request via API
        if ($request->expectsJson()) {
            $response = new JsonResponse([
                'success' => false,
                'message' => 'unauthenticated',
                'payload' => null,
            ], 401);

            return $response;
        }

        return redirect()->guest(route('main'));
    }
    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (Exception $exception, $request) {
            // dd($exception);
            if ($exception instanceof NotFoundHttpException) {
                if ($request->is('api/*')) {
                    $response = new JsonResponse([
                        'success' => false,
                        'message' => 'Not found',
                    ], 404);

                    return $response;
                }
            }
            if (method_exists($exception, "getStatusCode")) {
                if ($exception->getStatusCode() == 404) {
                    $response = new JsonResponse([
                        'success' => false,
                        'message' => 'Route not found',
                    ], 404);

                    return $response;
                }
            }
        });
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    protected function invalidJson($request, ValidationException $exception)
    {
        $response = new JsonResponse([
            'success' => true,
            'message' => 'Validation errors',
            'payload' => $exception->errors(),
        ], $exception->status);

        return $response;
    }
}
