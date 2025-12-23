<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
        'password',
        'password_confirmation',
    ];

    /** Report or log an exception.
     * @param Exception $exception
     * @return mixed|void
     * @throws Exception
     */
    public function report(Throwable  $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function render($request, Throwable  $exception)
    {
        if ($exception instanceof ModelNotFoundException &&
            $request->wantsJson()) {
            return response()->json([
                'data' => 'Resource not found'
            ], 404);
        } else if ($request->wantsJson()) {
            if ($exception->getCode() == 500) {
                return response()->json([
                    'data' => 'Something went wrong! Server Error!'
                ], 500);
            } else {
                return response()->json([
                    'data' => $exception->getMessage()
                ], 401);
            }
        }
        return parent::render($request, $exception);
    }

    /** For handling Api 401 response
     * @param \Illuminate\Http\Request $request
     * @param AuthenticationException $exception
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json(['error' => 'Unauthenticated'], 401);
    }

}
