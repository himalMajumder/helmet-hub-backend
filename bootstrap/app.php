<?php

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (\Throwable $exception, \Illuminate\Http\Request $request) {

            if ($request->is('api/*') || $request->wantsJson()) {

                if ($exception instanceof ValidationException) {
                    $errors = $exception->errors();

                    $allErrors = [];

                    foreach ($errors as $key => $error) {
                        $allErrors[$key] = $error[0];
                    }

                    return response()->json([
                        'status_code' => 422,
                        'message'     => 'Invalid data',
                        'data'        => null,
                        'errors'      => $allErrors,
                    ], 422);

                } elseif ($exception instanceof ModelNotFoundException) {

                    return response()->json([
                        'status_code' => 404,
                        'message'     => $exception->getMessage(),
                        'data'        => null,
                        'errors'      => [],
                    ], 404);
                } elseif (
                    $exception instanceof AuthorizationException
                    || $exception instanceof UnauthorizedException
                    || $exception instanceof AccessDeniedHttpException
                ) {
                    return response()->json([
                        'status_code' => 403,
                        'message'     => $exception->getMessage(),
                        'data'        => null,
                        'errors'      => [],
                    ], 403);

                } elseif ($exception instanceof AuthenticationException) {

                    return response()->json([
                        'status_code' => 401,
                        'message'     => $exception->getMessage(),
                        'data'        => null,
                        'errors'      => [],
                    ]);

                } elseif ($exception instanceof UnauthorizedHttpException) {
                    return response()->json([
                        'status_code' => 401,
                        'message'     => 'Token has expired or is invalid.',
                        'data'        => null,
                        'errors'      => [],
                    ], 401);
                } elseif ($exception instanceof NotFoundHttpException) {
                    return response()->json([
                        'status_code' => 404,
                        'message'     => $exception->getMessage(),
                        'data'        => null,
                        'errors'      => [],
                    ], 404);
                } elseif ($exception instanceof RouteNotFoundException) {

                    return response()->json([
                        'status_code' => 401,
                        'message'     => 'Unauthorized',
                        'data'        => null,
                        'errors'      => 'Authentication required. Please provide a valid token.',
                    ], 401);
                }

                return response()->json([
                    'status_code' => 500,
                    'message'     => $exception->getMessage(),
                    'data'        => get_class($exception),
                    'errors'      => [],
                ], 500);
            }

            if ($exception->getPrevious() instanceof TokenMismatchException) {
                return redirect()->back()->withInput($request->except('_token'));
            }

        });
    })
    ->create();
