<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        if (getenv('VERCEL') === '1') {
            $tmp = '/tmp/laravel';
            $tmpStorage = $tmp . '/storage';

            $this->app->useStoragePath($tmpStorage);

            config(['session.driver' => 'array']);
            config(['session.files' => $tmpStorage . '/framework/sessions']);
            config(['cache.default' => 'array']);
            config(['cache.stores.file.path' => $tmpStorage . '/framework/cache/data']);
            config(['cache.stores.file.lock_path' => $tmpStorage . '/framework/cache/data']);
            config(['view.compiled' => $tmpStorage . '/framework/views']);
            config(['database.connections.sqlite.database' => $tmp . '/database.sqlite']);
        }
    }
}
