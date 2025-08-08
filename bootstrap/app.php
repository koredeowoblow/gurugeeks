<?php

use App\Class\ApiResponse;
use App\Enums\StatusCode;
use App\Enums\StatusCodeEnums;
use App\Http\Middleware\AdminAuthenticate;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

if (!function_exists('registerApiRouteV1')) {
    function registerApiRouteV1($prefix, $file_name)
    {
        return Route::middleware("api")
            ->prefix("api/v1/$prefix")
            ->group(base_path("routes/api/v1/$file_name"));
    }
}
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        using: function () {

            Route::middleware("api")
                ->prefix("api")
                ->group(base_path("routes/api.php"));


        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
        $exceptions->render(function (HttpException $ex) {
            if ($ex->getStatusCode() === 404) {
                if ($ex->getPrevious() instanceof ModelNotFoundException) {
                    return ApiResponse::failed('Resource not found', [], [], 422);
                }
            }
            $body = $ex->getHeaders();
            $code = $body["code"] ?? StatusCode::FAILED;
            $data = $body["data"] ?? [];
            $errors = $body["errors"] ?? [];
            return ApiResponse::custom($code, $ex->getMessage(), $data, $errors, $ex->getStatusCode() ?? 422);
        });

        $exceptions->render(function (ValidationException $ex) {
            return ApiResponse::failed($ex->getMessage(), [], $ex->errors(), 400);
        });

        $exceptions->render(function (ModelNotFoundException $ex) {
            $model = class_basename($ex->getModel());
            return ApiResponse::failed("$model not found", [], [], 404);
        });
        $exceptions->render(function (Exception $ex) {
            return ApiResponse::failed($ex->getMessage(), [], [], 422);
        });
    })->create();
