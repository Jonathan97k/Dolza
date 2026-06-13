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
            $tmpStorage = '/tmp/laravel/storage';

            $this->app->useStoragePath($tmpStorage);

            config(['session.files' => $tmpStorage . '/framework/sessions']);
            config(['cache.stores.file.path' => $tmpStorage . '/framework/cache/data']);
            config(['cache.stores.file.lock_path' => $tmpStorage . '/framework/cache/data']);
            config(['view.compiled' => $tmpStorage . '/framework/views']);
        }
    }
}
