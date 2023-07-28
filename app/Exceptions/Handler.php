<?php

namespace App\Exceptions;

use http\Exception;
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
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success'=>false,
                    'message' => 'Record not found.'
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
