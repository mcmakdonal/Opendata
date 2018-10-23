<?php

return [
    // 'oracle' => [
    //     'driver'         => 'oracle',
    //     'tns'            => env('DB_TNS', '(description= (address=(protocol=tcps)(port=1522)(host=adwc.uscom-east-1.oraclecloud.com))(connect_data=(service_name=prbrfzqwbw5m6mz_mcbdpdcdb1_high.atp.oraclecloud.com))(security=(ssl_server_cert_dn=
    //     "CN=adwc.uscom-east-1.oraclecloud.com,OU=Oracle BMCS US,O=Oracle Corporation,L=Redwood City,ST=California,C=US"))   )'),
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
        'tns' => '(description= (address=(protocol=tcps)(port=1522)(host=adwc.uscom-east-1.oraclecloud.com))(connect_data=(service_name=prbrfzqwbw5m6mz_mcbdpdcdb1_low.atp.oraclecloud.com))(security=(ssl_server_cert_dn=
        "CN=adwc.uscom-east-1.oraclecloud.com,OU=Oracle BMCS US,O=Oracle Corporation,L=Redwood City,ST=California,C=US"))   )',
        'database' => 'ATP',
        'username' => 'admin',
        'password' => 'Rqo&wq3U5LpYJ@IN3a',
    ],
];
