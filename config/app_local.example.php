<?php

return [
    'debug' => filter_var(env('DEBUG', true), FILTER_VALIDATE_BOOLEAN),

    'Security' => [
        'salt' => env('SECURITY_SALT', '__SALT__'),
    ],

    'Datasources' => [
        'default' => [
            'host' => env('MYSQL_HOST', null),
            'username' => env('MYSQL_USER', null),
            'password' => env('MYSQL_PASSWORD', null),
            'database' => env('MYSQL_DATABASE', null),
            'url' => env('DATABASE_URL', null),
        ],

        /*
         * The test connection is used during the test suite.
         */
        'test' => [
            'host' => 'localhost',
            //'port' => 'non_standard_port_number',
            'username' => 'my_app',
            'password' => 'secret',
            'database' => 'test_myapp',
            //'schema' => 'myapp',
            'url' => env('DATABASE_TEST_URL', 'sqlite://127.0.0.1/tmp/tests.sqlite'),
        ],
    ],

    'EmailTransport' => [
        'default' => [
            'className' => 'Smtp',
            'host' => env('SMTP_HOST', 'localhost'),
            'port' => env('SMTP_PORT', 25),
            'username' => env('SMTP_USERNAME', null),
            'password' => env('SMTP_PASSWORD', null),
            'client' => null,
            'url' => env('EMAIL_TRANSPORT_DEFAULT_URL', null),
        ],
    ],
];
