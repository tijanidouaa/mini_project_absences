<?php
// ============================================================
// FICHIER 2 : bootstrap/app.php  (Laravel 11)
// Remplace ton bootstrap/app.php par ceci :
// ============================================================

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

        // ── Enregistrer les middlewares personnalisés ──
        $middleware->alias([
            'role'       => \App\Http\Middleware\CheckRole::class,
            'log.action' => \App\Http\Middleware\LogUserAction::class,
        ]);

        // ── Middleware auth par défaut ──
        $middleware->redirectGuestsTo('/login');
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
