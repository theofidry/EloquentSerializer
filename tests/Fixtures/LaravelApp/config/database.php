<?php
return [
    'fetch' => PDO::FETCH_CLASS,
    'default' => 'sqlite',
    'connections' => [
        'sqlite' => [
            'driver' => 'sqlite',
            'database' => database_path('database.sqlite'),
            'prefix' => '',
        ],
    ],
    'migrations' => 'migrations',
];
