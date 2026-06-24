<?php

foreach ([
    'APP_CONFIG_CACHE' => '/tmp/laravel-config.php',
    'APP_EVENTS_CACHE' => '/tmp/laravel-events.php',
    'APP_PACKAGES_CACHE' => '/tmp/laravel-packages.php',
    'APP_ROUTES_CACHE' => '/tmp/laravel-routes.php',
    'APP_SERVICES_CACHE' => '/tmp/laravel-services.php',
    'VIEW_COMPILED_PATH' => '/tmp/laravel-views',
] as $key => $value) {
    if (! getenv($key)) {
        putenv($key.'='.$value);
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
}

if (! is_dir('/tmp/laravel-views')) {
    mkdir('/tmp/laravel-views', 0777, true);
}

require __DIR__.'/../public/index.php';
