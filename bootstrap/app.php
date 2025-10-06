<?php

use App\Helpers\ApiResponse;
use App\Http\Middleware\ConvertPersianNumbers;
use App\Http\Middleware\LangLocale;
use App\Http\Middleware\LogPageVisit;
use App\Http\Middleware\RedirectIfRole;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use RealRashid\SweetAlert\ToSweetAlert;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            ToSweetAlert::class,
            LangLocale::class,
            ConvertPersianNumbers::class,
            \App\Http\Middleware\ForceHttps::class,
            LogPageVisit::class,
        ]);
        // Middleware aliases
        $middleware->alias([
            // Authentication & Authorization
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
            'RoleType' => RedirectIfRole::class,
            'secure.upload' => \App\Http\Middleware\SecureFileUpload::class,
            'LangLocale' => LangLocale::class,
            'Alert' => ToSweetAlert::class,
            'LogPageVisit' => LogPageVisit::class,

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->renderable(function (HttpExceptionInterface $e, Request $request) {
            if ($request->is('api/*')) {
                $statusCode = $e->getStatusCode();
                $message = match (true) {
                    $e instanceof NotFoundHttpException => 'صفحه مورد نظر یافت نشد',
                    $e instanceof AuthenticationException => 'دسترسی غیرمجاز',
                    default => 'خطایی رخ داده است',
                };

                return ApiResponse::error(
                    message: $message,
                    status: $statusCode ?? 500,
                    errors: [$e->getMessage()]
                );
            }

            return null;
        });
        $exceptions->renderable(function (AuthenticationException $e, Request $request) {
            if ($request->is('api/*')) {
                return ApiResponse::error(
                    message: 'دسترسی غیرمجاز',
                    status: 403,
                    errors: [$e->getMessage()]
                );
            }

            return null;
        });
    })->create();
