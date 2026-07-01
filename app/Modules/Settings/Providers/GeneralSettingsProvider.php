<?php

declare(strict_types=1);

namespace CDGStudio\Modules\Settings\Providers;

use CDGStudio\Contracts\SettingsProviderInterface;
use CDGStudio\Modules\Settings\DTO\SettingsField;
use CDGStudio\Modules\Settings\DTO\SettingsSection;
use CDGStudio\Modules\Settings\SettingsRegistry;
use CDGStudio\Modules\Settings\Providers\GeneralSettingsProvider;

final class GeneralSettingsProvider implements SettingsProviderInterface
{
    public function register(SettingsRegistry $registry): void
    {
        $registry->addSection(new SettingsSection(
            id: 'general',
            title: 'Général',
            description: 'Réglages généraux de CDG Studio.',
            icon: 'dashicons-admin-generic',
            order: 10
        ));

        $registry->addField(new SettingsField(
            key: 'plugin_name',
            section: 'general',
            label: 'Nom du plugin',
            type: 'text',
            default: 'CDG Studio',
            description: 'Nom affiché dans l’interface d’administration.'
        ));

        $registry->addField(new SettingsField(
            key: 'debug_mode',
            section: 'general',
            label: 'Mode debug',
            type: 'checkbox',
            default: false,
            description: 'Active des informations de diagnostic supplémentaires.'
        ));
    }
}