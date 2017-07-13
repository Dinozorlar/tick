<?php
return [
    'app.debug' => true,
    'db.config' => [
        'dbs.options' => [
            'tick' => [
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
    ],
];