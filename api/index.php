<?php

error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);
ini_set('display_errors', '1');
ini_set('log_errors', '1');

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

try {
    $appBase = dirname(__DIR__);

    if (getenv('VERCEL') === '1') {
        $tmp = '/tmp/laravel';

        foreach ([
            'storage/framework/cache/data',
            'storage/framework/sessions',
            'storage/framework/views',
            'storage/logs',
            'storage/app/public',
            'storage/app/private',
        ] as $dir) {
            $path = $tmp . '/' . $dir;
            if (!is_dir($path)) {
                mkdir($path, 0755, true);
            }
        }

        $dbSource = $appBase . '/database/database.sqlite';
        $dbTmp = $tmp . '/database.sqlite';
        if (file_exists($dbSource) && !file_exists($dbTmp)) {
            copy($dbSource, $dbTmp);
        }

        putenv('DB_DATABASE=' . $dbTmp);
        $_ENV['DB_DATABASE'] = $dbTmp;

        putenv('SESSION_DRIVER=array');
        $_ENV['SESSION_DRIVER'] = 'array';

        putenv('CACHE_DRIVER=array');
        $_ENV['CACHE_DRIVER'] = 'array';

        putenv('VIEW_COMPILED_PATH=' . $tmp . '/storage/framework/views');
        $_ENV['VIEW_COMPILED_PATH'] = $tmp . '/storage/framework/views';

        putenv('LOG_PATH=' . $tmp . '/storage/logs/laravel.log');
        $_ENV['LOG_PATH'] = $tmp . '/storage/logs/laravel.log';
    }

    require $appBase . '/vendor/autoload.php';

    $app = require_once $appBase . '/bootstrap/app.php';

    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

    $response = $kernel->handle(
        $request = Request::capture()
    )->send();

    $kernel->terminate($request, $response);
} catch (Throwable $e) {
    http_response_code(500);
    header('Content-Type: text/plain; charset=utf-8');
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "Trace:\n" . $e->getTraceAsString();
}
