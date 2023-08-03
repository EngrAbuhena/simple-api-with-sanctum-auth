<?php

namespace App\Exceptions;

use http\Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
    // This function will replace 404 error page with json response
    public function register(): void
    {
        // 401 Exception
        $this->renderable(function (AuthenticationException $e, $request) {
            if ($request->is('api/*')) {
                return $request->expectsJson() ?: response()->json([
                    'success'=>false,
                    'message' => 'Unauthenticated.',
                    'status' => 401,
                    'Description' => 'Missing or Invalid Access Token'
                ], 401);
            }
        });

        // 404 Exception
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                return $request->expectsJson() ?: response()->json([
                    'success'=>false,
                    'message' => 'Not Found.',
                    'status' => 404,
                    'Description' => 'Resource Not Found.'
                ], 404);
            }
        });
    }

//    public function render($request, Exception|Throwable $e)
//    {
//        // this will replace 404 page with json response
//        if ($e instanceof ModelNotFoundException && $request->wantsJson()) {
//            return response()->json([
//                'success'=>false,
//                'message' => 'Resource Not Found'
//            ], 404);
//        }
//        return parent::render($request, $e);
//    }

}
