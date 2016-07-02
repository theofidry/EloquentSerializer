<?php

/*
 * This file is part of the EloquentSerializer package.
 * 
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fidry\EloquentSerializer\Illuminate\Provider;

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
        $this->app->singleton(
            'serializer.normalizer.date_time',
            \Symfony\Component\Serializer\Normalizer\DateTimeNormalizer::class
        );
        $this->app->tag('serializer.normalizer.date_time', 'serializer.normalizer');

        $this->app->singleton(
            'serializer.normalizer.eloquent_model',
            \Fidry\EloquentSerializer\Symfony\Serializer\Normalizer\EloquentModelNormalizer::class
        );
        $this->app->tag('serializer.normalizer.eloquent_model', 'serializer.normalizer');

        $this->app->singleton(
            'serializer.normalizer.object',
            \Symfony\Component\Serializer\Normalizer\ObjectNormalizer::class
        );
        $this->app->tag('serializer.normalizer.object', 'serializer.normalizer');

        $this->app->singleton(
            'serializer',
            function (Application $app) {
                $normalizers = $app->tagged('serializer.normalizer');
                $encoders = $app->tagged('serializer.encoder');

            return new \Symfony\Component\Serializer\Serializer($normalizers, $encoders);
        });
        $this->app->bind(\Symfony\Component\Serializer\Normalizer\NormalizerInterface::class, 'serializer');
        $this->app->bind(\Symfony\Component\Serializer\Normalizer\DenormalizerInterface::class, 'serializer');
        $this->app->bind(\Symfony\Component\Serializer\Encoder\EncoderInterface::class, 'serializer');
        $this->app->bind(\Symfony\Component\Serializer\Encoder\DecoderInterface::class, 'serializer');
        $this->app->bind(\Symfony\Component\Serializer\SerializerInterface::class, 'serializer');
    }
}
