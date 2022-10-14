<?php

declare(strict_types=1);

/*
 * This file is part of the metten-promocodes-bundle.
 *
 * (c) Stefan Schulz-Lauterbach
 *
 * @license proprietary
 */

namespace Clickpress\Update\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class ClickpressUpdateExtension extends Extension
{
    public function load(array $mergedConfig, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../../config')
        );

        $loader->load('services.yaml');
    }
}
