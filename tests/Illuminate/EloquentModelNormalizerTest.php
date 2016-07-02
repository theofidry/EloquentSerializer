<?php

namespace Fidry\EloquentSerializer\Illuminate;

use Fidry\EloquentSerializer\TestCaseTrait;

class EloquentModelNormalizerTest extends FunctionalTestCase
{
    use TestCaseTrait;

    public function setUp()
    {
        parent::setUp();

        $this->serializer = $this->app->make('serializer');
    }
}
