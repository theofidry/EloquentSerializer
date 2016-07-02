<?php

/*
 * This file is part of the EloquentSerializer package.
 * 
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [
    'fetch' => PDO::FETCH_CLASS,
    'default' => 'sqlite',
    'connections' => [
        'sqlite' => [
            'driver' => 'sqlite',
            'database' => __DIR__.'/../../database.sqlite',
            'prefix' => '',
        ],
    ],
    'migrations' => 'migrations',
];
