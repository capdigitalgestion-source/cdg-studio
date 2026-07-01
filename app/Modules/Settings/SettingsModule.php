<?php

declare(strict_types=1);

namespace CDGStudio\Modules\Settings;

use CDGStudio\Core\AbstractModule;

final class SettingsModule extends AbstractModule
{
    /**
     * Nom technique du module.
     */
    public function name(): string
    {
        return 'settings';
    }

    /**
     * Enregistrement des services du module.
     */
    public function register(): void
    {
        // Les services seront enregistrés ici.
    }

    /**
     * Initialisation du module.
     */
    public function boot(): void
    {
        // Les hooks WordPress seront ajoutés ici.
    }
}