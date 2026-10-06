<?php

declare(strict_types=1);

namespace Supertext\PimcoreTranslationBundle\Installer;

use Pimcore\Db;
use Pimcore\Extension\Bundle\Installer\SettingsStoreAwareInstaller;
use Pimcore\Model\User\Permission\Definition;
use Supertext\PimcoreTranslationBundle\Settings;

/**
 * Adds the permission "supertext_translate" (Users → Roles/Users → Permissions).
 */
final class Installer extends SettingsStoreAwareInstaller
{
    public function install(): void
    {
        if (!Definition::getByKey(Settings::PERMISSION)) {
            Definition::create(Settings::PERMISSION)->setCategory('Supertext')->save();
        }
        parent::install();
    }

    public function uninstall(): void
    {
        Db::get()->delete('users_permission_definitions', ['`key`' => Settings::PERMISSION]);
        parent::uninstall();
    }
}
