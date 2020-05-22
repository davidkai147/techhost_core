<?php
namespace App\Exceptions;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class CustomHandler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    public function report(Throwable $exception)
    {
        parent::report($exception);
    }
    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        // check and response error when request empty token in header
        $not_found_token = $this->check_token_not_provider($exception);
        if (!empty($not_found_token))
            return $this->render_token_not_provider();

        // PLEASE ADD THIS LINES
        if ($exception instanceof UnauthorizedHttpException) {

            $preException = $exception->getPrevious();
            if ($preException instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return $this->render_token_expired();
            }
            else if ($preException instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return $this->render_token_invalid();
            }
            else if ($preException instanceof \Tymon\JWTAuth\Exceptions\TokenBlacklistedException) {
                return $this->render_token_blacklisted();
            }
        }

        return parent::render($request, $exception);
    }
    private

    function check_token_not_provider($exception)
    {
        return $exception->getMessage() === 'Token not provided';
    }

    function render_token_not_provider()
    {
        $params = [
            'message' => 'Please check and add token in header params.',
            'code' => 400
        ];
        return response()->json($params, 400);
    }

    function render_token_expired()
    {
        return $this->renderUnauthenticated('The token has expired!');
    }

    function render_token_invalid()
    {
        return $this->renderUnauthenticated('The token has invalid!');
    }

    function render_token_blacklisted()
    {
        return $this->renderUnauthenticated('The token in black list!');
    }

    function renderUnauthenticated($msg)
    {
        list($cookieToken, $cookieType) = $this->clearCookie();
        return response()
            ->json(['message' => $msg], 401)
            ->withCookie($cookieToken)
            ->withCookie($cookieType);
    }

    function clearCookie()
    {
        $cookieToken = \Cookie::forget('access_token');
        $cookieType = \Cookie::forget('type');

        return [$cookieToken, $cookieType];
    }
}
