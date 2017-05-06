# EloquentSerializer

[![Package version](http://img.shields.io/packagist/vpre/theofidry/eloquent-serializer.svg?style=flat-square)](https://packagist.org/packages/theofidry/eloquent-serializer)
[![Build Status](https://img.shields.io/travis/theofidry/EloquentSerializer.svg?branch=master&style=flat-square)](https://travis-ci.org/theofidry/EloquentSerializer?branch=master)
[![License](https://img.shields.io/badge/license-MIT-red.svg?style=flat-square)](LICENSE)

Package to allow [Symfony Serializer][1] to work on [Eloquent models][2].


## Table of Contents

1. [Install](#install)
    1. [Laravel](#laravel-540)
    1. [Symfony](#symfony-32)
1. [Usage](#usage)
1. [Contributing](#contributing)


## Install

You can use [Composer](https://getcomposer.org/) to install the bundle to your project:

```bash
composer require theofidry/eloquent-serializer
```


### Laravel (~5.4.0)

Add the provider [`Fidry\EloquentSerializer\Bridge\Laravel\Provider\SerializerProvider`](src/Illuminate/Provider/SerializerProvider.php) to your application providers:

```php
<?php
// config/app.php

'providers' => [
    // ...
    \Fidry\EloquentSerializer\Bridge\Laravel\Provider\SerializerProvider::class,
];
```


### Symfony (^3.2)

Enable the bundle by updating your `app/AppKernel.php` file to enable the bundle:

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    //...
    $bundles[] = new Fidry\EloquentSerializer\Bridge\Symfony\FidryEloquentSerializerBundle();

    return $bundles;
}
```


## Usage

```php
use Fidry\EloquentSerializer\Bridge\Laravel\Facade\Serializer;

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

// $normalizedDummy: [
//     'id' => 100,
//     'name' => 'Gunner Runte',
//     'email' => 'vbrekke@example.com',
//     'created_at' => '2016-07-02T12:28:14+00:00',
// ];
```


## Contributing

1. Install the packages:

```
composer install; composer bin all install
```

2. Setup the sqlite database:

```
bin/setup
```

3. Run the tests for the core library and the framework bridges:

```
bin/tests
```


[1]: http://symfony.com/doc/current/components/serializer.html
[2]: https://laravel.com/docs/5.2/eloquent#eloquent-model-conventions
