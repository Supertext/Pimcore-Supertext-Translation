<?php

declare(strict_types=1);

namespace Supertext\PimcoreTranslationBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

final class SupertextTranslationExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $config = $this->processConfiguration(new Configuration(), $configs);
        $container->setParameter('supertext_translation.config', $config);
        (new YamlFileLoader($container, new FileLocator(__DIR__ . '/../../config')))->load('services.yaml');
    }
}
