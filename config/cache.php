<?php

return [
    'default' => env('CACHE_DRIVER', 'file'),
    'stores' => [
        'file' => [
            'driver' => 'file',
            'path' => env('CACHE_PATH', storage_path('framework/cache/data')),
            'lock_path' => env('CACHE_LOCK_PATH', storage_path('framework/cache/data')),
        ],
        'array' => [
            'driver' => 'array',
            'serialize' => false,
        ],
    ],
    'prefix' => env('CACHE_PREFIX', 'laravel_cache'),
];
