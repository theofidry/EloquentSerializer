<?php

/*
 * This file is part of the EloquentSerializer package.
 * 
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fidry\EloquentSerializer\Bridge\Laravel\Serializer\Normalizer;

use Fidry\EloquentSerializer\Bridge\Laravel\FunctionalTestCase;
use Fidry\EloquentSerializer\TestCaseTrait;

/**
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class EloquentModelNormalizerTest extends FunctionalTestCase
{
    use TestCaseTrait;

    public function setUp()
    {
        parent::setUp();

        $this->serializer = $this->app->make('serializer');
    }
}
