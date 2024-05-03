<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use App\Http\Middleware\EnsureSession;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(EnsureSession::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        
        $exceptions->render(function (App\Exceptions\InvalidRoleRoute $e, Request $request) {
            return response()->view('errors.illegalroute', [], 500);
        });
    })->create();
