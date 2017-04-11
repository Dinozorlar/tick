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
            'tick' => [
                'driver' => 'pdo_mysql',
                'host' => 'localhost',
                'password' => 'root',
                'user' => 'root',
                'dbname' => 'tick',
                'charset' => 'UTF8'
            ],
            'turuvalihelen' => [
                'driver' => 'pdo_mysql',
                'host' => 'localhost',
                'password' => 'root',
                'user' => 'root',
                'dbname' => 'tick_logs',
                'charset' => 'UTF8'
            ]
        ]
    ],
    'orm.config' => [
        'orm.proxies_dir' => APP_ROOT_DIR . '/var/cache/proxies',
        'orm.auto_generate_proxies' => true,
        'orm.default_cache' => [
            'driver' => 'array'
        ],
        'orm.ems.options' => [
            'tick' => [
                'connection' => 'tick',
                'mappings' => [
                    [
                        'type' => 'annotation',
                        'namespace' => 'Tick\Entity',
                        'path' => APP_ROOT_DIR . '/src/Tick/Entity',
                        'use_simple_annotation_reader' => false,
                        'alias' => 'Tick'
                    ]
                ]
            ]
        ]
    ]
];