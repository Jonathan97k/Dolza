<?php

error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

$isVercel = getenv('VERCEL') === '1';

if ($isVercel) {
    $tmp = '/tmp/laravel';
    $appBase = dirname(__DIR__);

    $dirs = [
        'storage/framework/cache/data',
        'storage/framework/sessions',
        'storage/framework/views',
        'storage/logs',
        'storage/app/public',
        'storage/app/private',
    ];

    foreach ($dirs as $dir) {
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

    putenv('CACHE_PATH=' . $tmp . '/storage/framework/cache/data');
    $_ENV['CACHE_PATH'] = $tmp . '/storage/framework/cache/data';

    putenv('CACHE_LOCK_PATH=' . $tmp . '/storage/framework/cache/data');
    $_ENV['CACHE_LOCK_PATH'] = $tmp . '/storage/framework/cache/data';

    putenv('SESSION_FILE=' . $tmp . '/storage/framework/sessions');
    $_ENV['SESSION_FILE'] = $tmp . '/storage/framework/sessions';

    if (file_exists($appBase . '/storage/framework/maintenance.php')) {
        $maintenance = $tmp . '/storage/framework/maintenance.php';
        if (!file_exists($maintenance)) {
            copy($appBase . '/storage/framework/maintenance.php', $maintenance);
        }
        require $maintenance;
    }
} else {
    $appBase = dirname(__DIR__);
    if (file_exists($appBase . '/storage/framework/maintenance.php')) {
        require $appBase . '/storage/framework/maintenance.php';
    }
}

require $appBase . '/vendor/autoload.php';

$app = require_once $appBase . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
