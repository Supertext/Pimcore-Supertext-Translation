<?php

declare(strict_types=1);

namespace Supertext\PimcoreTranslationBundle\Webpack;

use Pimcore\Bundle\StudioUiBundle\Webpack\WebpackEntryPointProviderInterface;

/**
 * Registers the Studio plugin (public/build/<build-id>/entrypoints.json, built from assets/).
 */
final class WebpackEntryPointProvider implements WebpackEntryPointProviderInterface
{
    public function getEntryPointsJsonLocations(): array
    {
        return glob(__DIR__ . '/../../public/build/*/entrypoints.json') ?: [];
    }

    public function getEntryPoints(): array
    {
        return ['exposeRemote'];
    }

    public function getOptionalEntryPoints(): array
    {
        return [];
    }
}
