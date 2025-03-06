<?php

use App\Http\Middleware\AdminOrTeacher;
use App\Http\Middleware\onlyAdmin;
use App\Http\Middleware\onlyTeacher;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'adminOrTeacher' => AdminOrTeacher::class,
            'onlyAdmin' => onlyAdmin::class,
            'onlyTeacher' => onlyTeacher::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
