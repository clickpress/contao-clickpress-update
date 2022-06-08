<?php

declare(strict_types=1);

/*
 * This file is part of the metten-promocodes-bundle.
 *
 * (c) Stefan Schulz-Lauterbach
 *
 * @license proprietary
 */

namespace Clickpress\Update\ContaoManager;

use Clickpress\Update\ClickpressUpdateBundle;
use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Routing\RoutingPluginInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class Plugin implements BundlePluginInterface, RoutingPluginInterface
{
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(ClickpressUpdateBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }

    public function getRouteCollection(LoaderResolverInterface $resolver, KernelInterface $kernel)
    {
        $file = __DIR__.'/../Resources/config/routes.yaml';

        return $resolver->resolve($file)->load($file);
    }
}
