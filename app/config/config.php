<?php

$env = static function (string $key, $default = null) {
    $value = getenv($key);
    return $value !== false ? $value : $default;
};

return [
    'app' => [
        'name' => 'GoCreative Ges',
        'base_url' => $env('APP_BASE_URL', ''),
        'timezone' => $env('APP_TIMEZONE', 'America/Santiago'),
    ],
    'db' => [
        // Prioridad a variables de entorno para despliegues en hosting.
        'host' => $env('DB_HOST', 'localhost'),
        'port' => (int)$env('DB_PORT', 3306),
        'socket' => $env('DB_SOCKET', ''),
        'name' => $env('DB_NAME', 'gocreative_ges'),
        'user' => $env('DB_USER', 'root'),
        'pass' => $env('DB_PASS', ''),
        'charset' => $env('DB_CHARSET', 'utf8mb4'),
    ],
    'security' => [
        'csrf_key' => 'csrf_token',
    ],
    'currency_format' => [
        'thousands_separator' => '.',
        'decimal_separator' => ',',
        'decimals' => 0,
        'symbol' => '$',
    ],
];
