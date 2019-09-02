<?php

namespace FNZBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class FNZExtension extends Extension
{
    const THEME_REGISTRY_SERVICE_ID = 'oro_theme.registry';

    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $registryDefinition = $container->getDefinition(self::THEME_REGISTRY_SERVICE_ID);
        $registryDefinition->addMethodCall('setActiveTheme', ['fnz']);

    }
}
