<?php
return [
    'twig' => [
        'twig.path' => APP_ROOT_DIR . '/src/Tick/views'
    ],
    'twig.folders' => [
        [APP_ROOT_DIR . '/src/Tick/Web/App/Views', 'app']
    ],
    'app.debug' => false,
    'db.config' => [
        'dbs.options' => [
            'haydar' => [
                'driver' => 'pdo_mysql',
                'host' => 'localhost',
                'password' => '123456',
                'user' => 'root',
                'dbname' => 'tick',
                'charset' => 'UTF8'
            ],
            'turuvalihelen' => [
                'driver' => 'pdo_mysql',
                'host' => 'localhost',
                'password' => '123456',
                'user' => 'root',
                'dbname' => 'tick_logs',
                'charset' => 'UTF8'
            ]
        ]
    ]

];