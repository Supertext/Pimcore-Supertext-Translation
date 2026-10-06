<?php

declare(strict_types=1);

namespace Supertext\PimcoreTranslationBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;
use Pimcore\Extension\Bundle\Installer\InstallerInterface;
use Supertext\PimcoreTranslationBundle\Installer\Installer;

/**
 * Supertext Translation for Pimcore Studio.
 */
final class SupertextTranslationBundle extends AbstractPimcoreBundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    public function getInstaller(): InstallerInterface
    {
        return $this->container->get(Installer::class);
    }
}
