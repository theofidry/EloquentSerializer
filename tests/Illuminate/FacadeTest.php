<?php

namespace Fidry\EloquentSerializer\Illuminate;

use Fidry\EloquentSerializer\Illuminate\Facade\Serializer;

class FacadeTest extends FunctionalTestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testFacade()
    {
        $this->assertEquals(
            [],
            Serializer::normalize(new \stdClass())
        );
    }
}
