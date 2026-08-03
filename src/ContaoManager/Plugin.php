<?php

declare(strict_types=1);

namespace Clickpress\Update\ContaoManager;

use Clickpress\Update\ClickpressUpdateBundle;
use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Config\ContainerBuilder;
use Contao\ManagerPlugin\Config\ExtensionPluginInterface;
use Contao\ManagerPlugin\Routing\RoutingPluginInterface;
use Nelmio\CorsBundle\NelmioCorsBundle;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\RouteCollection;

class Plugin implements BundlePluginInterface, RoutingPluginInterface, ExtensionPluginInterface
{
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(NelmioCorsBundle::class),
            BundleConfig::create(ClickpressUpdateBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class, NelmioCorsBundle::class]),
        ];
    }

    public function getRouteCollection(LoaderResolverInterface $resolver, KernelInterface $kernel): RouteCollection
    {
        return $resolver
            ->resolve(__DIR__.'/../Controller')
            ->load(__DIR__.'/../Controller')
        ;
    }

    public function getExtensionConfig($extensionName, array $extensionConfigs, ContainerBuilder $container): array
    {
        if ('nelmio_cors' === $extensionName) {
            $extensionConfigs[] = [
                'paths' => [
                    '^/api/update/' => [
                        'allow_origin' => ['*'],
                        'allow_headers' => ['*'],
                        'allow_methods' => ['GET', 'OPTIONS'],
                        'max_age' => 3600,
                    ],
                ],
            ];
        }

        return $extensionConfigs;
    }
}
