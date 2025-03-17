<?php

return [
    'connection' => [
        'driver' => 'pdo_mysql',
        'charset' => 'utf8mb4',
        'host' => getenv('DB_HOST'),
        'port' => getenv('DB_PORT'),
        'dbname' => getenv('DB_NAME'),
        'user' => getenv('DB_USER'),
        'password' => getenv('DB_PASSWORD'),
    ],
    'dev_mode' => getenv('ENV') !== 'production',
    'cache_dir' => ROOT_PATH.'/var/doctrine',
    'metadata_dirs' => [ROOT_PATH.'/src/Entity'],
];
