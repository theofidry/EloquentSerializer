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
trait NotCallable
{
    public function __invoke($method, $args = [])
    {
        throw new \DomainException('Did not expected '.$method.' to be called.');
    }
}
