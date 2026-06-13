<?php
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$isVercel = getenv('VERCEL') === '1';

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->trustProxies(at: '*');
        $middleware->alias([
            'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
            'admin' => \App\Http\Middleware\IsAdmin::class,
        ]);
        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);
        $middleware->statefulApi();
        $middleware->validateCsrfTokens(except: [
            'api/*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $e, $request) {
            $debug = config('app.debug');
            $msg = $debug
                ? "Error: " . $e->getMessage() . "\nFile: " . $e->getFile() . ":" . $e->getLine() . "\n\n" . $e->getTraceAsString()
                : "Server Error";
            return new \Symfony\Component\HttpFoundation\Response($msg, 500, ['Content-Type' => 'text/plain']);
        });
    })
    ->create()
    ->usePublicPath(__DIR__.'/../public');

if ($isVercel) {
    $tmp = '/tmp/laravel';
    $app->useStoragePath($tmp.'/storage');
}

return $app;
