<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
     ->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
        'role' => \App\Http\Middleware\EnsureRole::class,
    ]);

    // Un utilisateur déjà connecté qui ouvre /login, /register… va sur SON tableau de bord
    $middleware->redirectUsersTo(function (Request $request) {
        return match ($request->user()?->role) {
            'superadmin'        => route('superadmin.dashboard'),
            'opticien', 'admin' => route('admin.dashboard'),
            'client'            => route('client.dashboard'),
            default             => '/',
        };
    });
})

    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
