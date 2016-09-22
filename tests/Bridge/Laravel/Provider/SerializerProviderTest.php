<?php

/*
 * This file is part of the EloquentSerializer package.
 *
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fidry\EloquentSerializer\Bridge\Laravel\Provider;

use Fidry\EloquentSerializer\Bridge\Laravel\FunctionalTestCase;

/**
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class SerializerProviderTest extends FunctionalTestCase
{
    public function testServicesAreRegistered()
    {
        $this->assertInstanceOf(
            \Symfony\Component\Serializer\Normalizer\DateTimeNormalizer::class,
            $this->app->make('serializer.normalizer.date_time')
        );
        $this->assertSame(
            $this->app->make(\Symfony\Component\Serializer\Normalizer\DateTimeNormalizer::class),
            $this->app->make('serializer.normalizer.date_time')
        );

        $this->assertInstanceOf(
            \Symfony\Component\Serializer\Normalizer\ObjectNormalizer::class,
            $this->app->make('serializer.normalizer.object')
        );
        $this->assertSame(
            $this->app->make(\Symfony\Component\Serializer\Normalizer\ObjectNormalizer::class),
            $this->app->make('serializer.normalizer.object')
        );

        $this->assertInstanceOf(
            \Symfony\Component\Serializer\Serializer::class,
            $this->app->make('serializer')
        );
        $this->assertSame(
            $this->app->make(\Symfony\Component\Serializer\Serializer::class),
            $this->app->make('serializer')
        );
    }

    public function testServicesAreBound()
    {
        $serializer = $this->app->make('serializer');
        $abstracts = [
            \Symfony\Component\Serializer\SerializerInterface::class,
            \Symfony\Component\Serializer\Normalizer\NormalizerInterface::class,
            \Symfony\Component\Serializer\Normalizer\DenormalizerInterface::class,
            \Symfony\Component\Serializer\Encoder\EncoderInterface::class,
            \Symfony\Component\Serializer\Encoder\DecoderInterface::class,
        ];

        foreach ($abstracts as $abstract) {
            $this->assertSame(
                $this->app->make($abstract),
                $serializer
            );
        }
    }
}
