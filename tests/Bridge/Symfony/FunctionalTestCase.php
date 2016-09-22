<?php

/*
 * This file is part of the EloquentSerializer package.
 * 
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fidry\EloquentSerializer\Bridge\Symfony;

use Fidry\EloquentSerializer\SymfonyApp\AppKernel;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @group Symfony
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
abstract class FunctionalTestCase extends KernelTestCase
{
    /**
     * @inheritdoc
     */
    protected static function createKernel(array $options = array())
    {
        static::$class = AppKernel::class;

        return parent::createKernel($options);
    }


}
