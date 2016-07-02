<?php

namespace Fidry\LaravelSerializerSymfony\Illuminate\Facade;

use Illuminate\Support\Facades\Facade as IlluminateFacade;

/**
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
final class SerializerFacade extends IlluminateFacade
{
    /**
     * @inheritdoc
     */
    protected static function getFacadeAccessor()
    {
        return 'serializer';
    }
}
