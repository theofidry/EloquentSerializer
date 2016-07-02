<?php

namespace Fidry\LaravelSerializerSymfony\Illuminate;

use Fidry\LaravelSerializerSymfony\TestCaseTrait;
use Illuminate\Foundation\Testing\TestCase as IlluminateTestCase;

class EloquentModelNormalizerTest extends IlluminateTestCase
{
    use TestCaseTrait;

    /**
     * @var string
     */
    public static $laravelAppBasePath;

    public function setUp()
    {
        static::$laravelAppBasePath = __DIR__.'/../Fixtures/LaravelApp/app.php';

        parent::setUp();

        $this->purgeDatabase();
        $this->serializer = $this->app->make('serializer');
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
