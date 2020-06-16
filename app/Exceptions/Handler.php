<?php

namespace App\Exceptions;

use Flugg\Responder\Exceptions\ConvertsExceptions;
use Flugg\Responder\Exceptions\Http\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ConvertsExceptions;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
         \Illuminate\Auth\AuthenticationException::class,
         \Illuminate\Auth\Access\AuthorizationException::class,
         \Symfony\Component\HttpKernel\Exception\HttpException::class,
         \Illuminate\Database\Eloquent\ModelNotFoundException::class,
         \Illuminate\Validation\ValidationException::class
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof InternalErrorException) {
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;

            return response()->json([
                'message' => $exception->getMessage(),
                'code' => $code
            ]);
        }

        return parent::render($request, $exception);
    }
}
