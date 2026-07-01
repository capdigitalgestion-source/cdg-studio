<?php

declare(strict_types=1);

namespace CDGStudio\Modules\Settings;

use CDGStudio\Core\AbstractModule;

final class SettingsModule extends AbstractModule
{
    private const MENU_SLUG = 'cdg-studio';

    public function register(): void
    {
    }

    public function boot(): void
    {
        $this->hooks()->action('admin_menu', [$this, 'registerMenu']);

        $this->logger()->info('SettingsModule boot OK');
    }

    public function registerMenu(): void
    {
        add_submenu_page(
            self::MENU_SLUG,
            'Réglages',
            'Réglages',
            'manage_options',
            'cdg-studio-settings',
            [$this, 'render']
        );
    }

    public function render(): void
    {
        echo '<div class="wrap">';
        echo '<h1>Réglages CDG Studio</h1>';
        echo '<p>Module Settings chargé avec succès.</p>';
        echo '</div>';
    }
}