<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
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
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Error! no se encuentra la url.'
                ], 404);
            }
        });

    }

    public function render($request, Throwable $exception)
    {
        // Check if the request expects JSON
        if ($request->expectsJson()) {
            $status = $exception instanceof HttpException ? $exception->getStatusCode() : 500;
            $message = $status == 500 ? 'Ha ocurrido un error en el servidor.' : $exception->getMessage();

            // Customize messages for other status codes
            if ($status == 404) {
                $message = 'Error! no se encuentra la url.';
            } elseif ($status == 403) {
                $message = 'Acceso prohibido.';
            }elseif ($status == 405) {
                $message = 'Error! metodo no permitido.';
            }

            return response()->json([
                'message' => $message
            ], $status);
        }

        return parent::render($request, $exception);
    }
}
