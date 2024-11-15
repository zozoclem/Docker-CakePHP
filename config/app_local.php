<?php

return [
    'debug' => filter_var(env('DEBUG', true), FILTER_VALIDATE_BOOLEAN),
    'App' => [
        'encoding' => 'UTF-8',
        'baseUrl' => false,
        'namespace' => 'App',
    ],
    'Database' => [
        'host' => 'db', // Nom du service Docker pour la base de données
        'username' => env('MYSQL_USER', 'cakephp_user'),
        'password' => env('MYSQL_PASSWORD', 'userpassword'),
        'database' => env('MYSQL_DATABASE', 'cakephp_db'),
        'url' => env('DATABASE_URL', null),
    ],
    'Security' => [
        'salt' => env('SECURITY_SALT', 'a_long_random_string'),
    ],
];

