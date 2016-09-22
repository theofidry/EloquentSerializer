<?php

/*
 * This file is part of the EloquentSerializer package.
 * 
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fidry\EloquentSerializer\Bridge\Laravel\Facade;

use Fidry\EloquentSerializer\Bridge\Laravel\FunctionalTestCase;

/**
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class FacadeTest extends FunctionalTestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testTheSerializerIsAccessibleViaTheFacade()
    {
        $this->assertEquals(
            [],
            Serializer::normalize(new \stdClass())
        );
    }
}
