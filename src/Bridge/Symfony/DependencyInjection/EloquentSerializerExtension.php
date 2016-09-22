<?php

namespace Fidry\EloquentSerializer\Bridge\Symfony\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
final class EloquentSerializerExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../../../../resources/config'));
        $loader->load('services.xml');
    }

    public function getAlias()
    {
        return 'fidry_eloquent_serializer';
    }
}
