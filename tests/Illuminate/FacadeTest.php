<?php

/*
 * This file is part of the EloquentSerializer package.
 * 
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fidry\EloquentSerializer\Illuminate;

use Fidry\EloquentSerializer\Illuminate\Facade\Serializer;

/**
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
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
