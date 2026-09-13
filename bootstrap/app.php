<?php

use App\Jobs\ReportCriticalError;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Throwable;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');

        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'exam.block' => \App\Http\Middleware\BlockCoursesDuringExams::class,
            'install.guard' => \App\Http\Middleware\RedirectIfInstalled::class,
        ]);

        $middleware->web(append: [
            \App\Http\Middleware\RedirectIfNotInstalled::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        $exceptions->report(function (Throwable $e): void {
            ReportCriticalError::dispatch(
                message: $e->getMessage(),
                exceptionClass: get_class($e),
                file: $e->getFile(),
                line: $e->getLine(),
            );
        });
    })->create();
