<?php

/*
 * This file is part of the EloquentSerializer package.
 * 
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fidry\EloquentSerializer\Bridge\Laravel;

use Illuminate\Foundation\Testing\TestCase as IlluminateTestCase;

/**
 * @group Laravel
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
abstract class FunctionalTestCase extends IlluminateTestCase
{
    /**
     * @var string
     */
    public static $laravelAppBasePath;

    public function setUp()
    {
        static::$laravelAppBasePath = realpath(__DIR__.'/../../../'.getenv('APP_DIR'));

        parent::setUp();
    }

    /**
     * @inheritdoc
     */
    public function createApplication()
    {
        $app = require static::$laravelAppBasePath;
        $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }
}
