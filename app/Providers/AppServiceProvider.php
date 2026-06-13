<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if (getenv('VERCEL') === '1') {
            $tmpStorage = '/tmp/laravel/storage';

            $this->app->useStoragePath($tmpStorage);

            $this->app->bind('path.storage', function () use ($tmpStorage) {
                return $tmpStorage;
            });
        }
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
