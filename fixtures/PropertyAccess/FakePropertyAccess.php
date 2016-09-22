<?php

/*
 * This file is part of the EloquentSerializer package.
 *
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fidry\EloquentSerializer\PropertyAccess;

use Fidry\EloquentSerializer\NotCallable;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

/**
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class FakePropertyAccess implements PropertyAccessorInterface
{
    use NotCallable;

    /**
     * @inheritdoc
     */
    public function setValue(&$objectOrArray, $propertyPath, $value)
    {
        $this->__invoke(__METHOD__, func_get_args());
    }

    /**
     * @inheritdoc
     */
    public function isWritable($objectOrArray, $propertyPath)
    {
        $this->__invoke(__METHOD__, func_get_args());
    }

    /**
     * @inheritdoc
     */
    public function isReadable($objectOrArray, $propertyPath)
    {
        $this->__invoke(__METHOD__, func_get_args());
    }

    /**
     * @inheritdoc
     */
    public function getValue($objectOrArray, $propertyPath)
    {
        $this->__invoke(__METHOD__, func_get_args());
    }
}
