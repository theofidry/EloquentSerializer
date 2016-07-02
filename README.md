# EloquentSerializer

[![Package version](http://img.shields.io/packagist/v/theofidry/eloquent-serializer.svg?style=flat-square)](https://packagist.org/packages/theofidry/eloquent-serializer)
[![License](https://img.shields.io/badge/license-MIT-red.svg?style=flat-square)](LICENSE)

Package to allow Symfony Serializer to work on Eloquent models.

## Install

You can use [Composer](https://getcomposer.org/) to install the bundle to your project:

```bash
composer require theofidry/eloquent-serializer
```

### Laravel

Add the provider [`Fidry\EloquentSerializer\Illuminate\Provider\SerializerProvider`](src/Illuminate/Provider/SerializerProvider.php) to your application providers:

```php
<?php
// config/app.php

'providers' => [
    // ...
    \Fidry\EloquentSerializer\Illuminate\Provider\SerializerProvider::class,
];
```

### Symfony

Enable the bundle by updating your `app/AppKernel.php` file to enable the bundle:

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    //...
    $bundles[] = new Fidry\EloquentSerializer\Symfony\Bundle\FidryEloquentSerializerBundle();

    return $bundles;
}
```

## Usage

```php
use Fidry\EloquentSerializer\Illuminate\Facade\Serializer;

// Dummy is an Eloquent model
$dummy = Dummy::create([
    'id' => 100,
    'name' => 'Gunner Runte',
    'email' => 'vbrekke@example.com',
    'password' => '$2y$10$j/R4kRrymk3wMXwohvoRou2zBKJZVecr1VON.9NnSXu24k6CP6tDe',
    'remember_token' => 'PhiasHkmCh',
    'created_at' => new Carbon('2016-07-02T12:28:14+00:00'),
]);

// You can either use the Facade (Laravel) or the 'serializer' service (Laravel & Symfony)
$normalizedDummy = Serializer::normalize($dummy);

/* $normalizedDummy: [
 *     'id' => 100,
 *     'name' => 'Gunner Runte',
 *     'email' => 'vbrekke@example.com',
 *     'created_at' => '2016-07-02T12:28:14+00:00',
 */ ];
```

## License

[![license](https://img.shields.io/badge/license-MIT-red.svg?style=flat-square)](LICENSE)

[1]: http://psysh.org/
[2]: http://symfony.com/