<?php

/*
 * This file is part of the EloquentSerializer package.
 *
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fidry\EloquentSerializer\Illuminate\Facade;

use Illuminate\Support\Facades\Facade as IlluminateFacade;

/**
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
final class Serializer extends IlluminateFacade
{
    /**
     * @inheritdoc
     */
    protected static function getFacadeAccessor()
    {
        return 'serializer';
    }
}
