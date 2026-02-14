<?php

use App\Http\Middleware\HandleAppearance;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->encryptCookies(except: ['appearance', 'sidebar_state']);

        $middleware->web(append: [
            HandleAppearance::class,
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
            \App\Http\Middleware\UserActivity::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            'webauthn/*',
        ]);

        $middleware->alias([
            'not.installed' => \App\Http\Middleware\CheckNotInstalled::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->respond(function (\Symfony\Component\HttpFoundation\Response $response, \Throwable $exception, \Illuminate\Http\Request $request) {
            if (in_array($response->getStatusCode(), [403, 404, 500, 503]) && !app()->environment(['testing'])) {
                return \Inertia\Inertia::render('Error', [
                    'status' => $response->getStatusCode(),
                    'message' => $exception->getMessage(),
                ])->toResponse($request)->setStatusCode($response->getStatusCode());
            }

            return $response;
        });
    })->create();
