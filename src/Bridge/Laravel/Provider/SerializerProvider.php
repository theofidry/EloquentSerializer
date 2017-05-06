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

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

/**
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
final class SerializerProvider extends IlluminateServiceProvider
{
    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->registerTaggedService(
            'serializer.encoder.json',
            \Symfony\Component\Serializer\Encoder\JsonEncoder::class,
            null,
            ['serializer.encoder']
        );

        $this->registerTaggedService(
            'serializer.normalizer.date_time',
            \Symfony\Component\Serializer\Normalizer\DateTimeNormalizer::class,
            null,
            ['serializer.normalizer']
        );

        $this->registerTaggedService(
            'serializer.normalizer.eloquent_model',
            \Fidry\EloquentSerializer\Serializer\Normalizer\EloquentModelNormalizer::class,
            null,
            ['serializer.normalizer']
        );

        $this->registerTaggedService(
            'serializer.normalizer.object',
            \Symfony\Component\Serializer\Normalizer\ObjectNormalizer::class,
            null,
            ['serializer.normalizer']
        );

        $this->registerTaggedService(
            'serializer',
            \Symfony\Component\Serializer\Serializer::class,
            function (Application $app) {
                $normalizers = $app->tagged('serializer.normalizer');
                $encoders = $app->tagged('serializer.encoder');

                return new \Symfony\Component\Serializer\Serializer($normalizers, $encoders);
            }
        );

        $this->app->bind(\Symfony\Component\Serializer\Normalizer\NormalizerInterface::class, 'serializer');
        $this->app->bind(\Symfony\Component\Serializer\Normalizer\DenormalizerInterface::class, 'serializer');
        $this->app->bind(\Symfony\Component\Serializer\Encoder\EncoderInterface::class, 'serializer');
        $this->app->bind(\Symfony\Component\Serializer\Encoder\DecoderInterface::class, 'serializer');
        $this->app->bind(\Symfony\Component\Serializer\SerializerInterface::class, 'serializer');
    }

    /**
     * @param string   $id
     * @param string   $class
     * @param callable $constructor
     * @param string[] $tags
     */
    private function registerTaggedService($id, $class, callable $constructor = null, array $tags = [])
    {
        if (null === $constructor) {
            $constructor = function () use ($class) {
                return new $class();
            };
        }

        $this->app->singleton($id, $constructor);
        $this->app->bind($class, $id);
        foreach ($tags as $tag) {
            $this->app->tag($id, $tag);
        }
    }
}
