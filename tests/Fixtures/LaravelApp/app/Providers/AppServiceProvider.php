<?php

namespace App\Providers;

use App\Symfony\Serializer\Normalizer\EloquentModelNormalizer;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Encoder\EncoderInterface;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->tag(DateTimeNormalizer::class, 'serializer.normalizer');
        $this->app->tag(EloquentModelNormalizer::class, 'serializer.normalizer');

        $this->app->singleton('serializer', function ($app) {
            $normalizers = $app->tagged('serializer.normalizer');
            $encoders = $app->tagged('serializer.encoder');

            return new Serializer($normalizers, $encoders);
        });
        $this->app->bind(NormalizerInterface::class, 'serializer');
        $this->app->bind(EncoderInterface::class, 'serializer');
        $this->app->bind(DenormalizerInterface::class, 'serializer');
        $this->app->bind(DecoderInterface::class, 'serializer');
        $this->app->bind(SerializerInterface::class, 'serializer');
    }
}
