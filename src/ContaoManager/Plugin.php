<?php

use Nelmio\CorsBundle\NelmioCorsBundle;
use Contao\ManagerPlugin\Config\ExtensionPluginInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

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
