<?php

return [
    // 'oracle' => [
    //     'driver'         => 'oracle',
    //     'tns'            => env('ODB_HOST'),
    //     'host'           => env('DB_HOST', ''),
    //     'port'           => env('DB_PORT', '1521'),
    //     'database'       => env('DB_DATABASE', ''),
    //     'username'       => env('DB_USERNAME', ''),
    //     'password'       => env('DB_PASSWORD', ''),
    //     'charset'        => env('DB_CHARSET', 'AL32UTF8'),
    //     'prefix'         => env('DB_PREFIX', ''),
    //     'prefix_schema'  => env('DB_SCHEMA_PREFIX', ''),
    //     'edition'        => env('DB_EDITION', 'ora$base'),
    //     'server_version' => env('DB_SERVER_VERSION', '11g'),
    // ],
    'oracle' => [
        'driver' => 'oracle',
        'tns' => env('ODB_HOST'),
        'database' => env('ODB_DATABASE'),
        'username' => env('ODB_USERNAME'),
        'password' => env('ODB_PASSWORD'),
    ],
];
