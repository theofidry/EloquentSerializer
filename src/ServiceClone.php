<?php

/*
 * This file is part of the EloquentSerializer package.
 *
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fidry\EloquentSerializer;

/**
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
trait ServiceClone
{
    public function __clone()
    {
        throw new \DomainException('You should not clone a service.');
    }
}
