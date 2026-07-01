<?php

declare(strict_types=1);

namespace CDGStudio\Modules\Settings;

use CDGStudio\Core\AbstractModule;
use CDGStudio\Modules\Settings\Providers\GeneralSettingsProvider;

final class SettingsModule extends AbstractModule
{
    private const MENU_SLUG = 'cdg-studio-settings';

    public function register(): void
    {
       $this->container->set(
    'settings.registry',
    function () {
        $registry = new SettingsRegistry();
        $registry->addProvider(new GeneralSettingsProvider());
        $registry->boot();

        return $registry;
    }
);

        $this->container->set(
            'settings.service',
            fn () => new SettingsService(
                $this->container->get('settings.registry')
            )
        );

        $this->container->set(
            'settings.controller',
            fn () => new SettingsController(
                $this->container->get('settings.service'),
                $this->container->get('settings.registry')
                
            )
        );
    }

    public function boot(): void
    {
        $this->hooks()->action('admin_menu', [$this, 'registerMenu']);
        $this->hooks()->action('admin_enqueue_scripts', [$this, 'enqueueAssets']);

        $this->logger()->info('SettingsModule boot OK');
    }

    public function registerMenu(): void
    {
        /** @var SettingsController $controller */
        $controller = $this->container->get('settings.controller');

        add_submenu_page(
            'cdg-studio',
            'Réglages',
            'Réglages',
            'manage_options',
            self::MENU_SLUG,
            [$controller, 'render']
        );
    }

    public function enqueueAssets(string $hook): void
    {
        if (! str_contains($hook, self::MENU_SLUG)) {
            return;
        }

        wp_enqueue_style(
            'cdg-studio-settings',
            CDG_STUDIO_URL . 'app/Modules/Settings/Assets/settings.css',
            [],
            CDG_STUDIO_VERSION
        );

        wp_enqueue_script(
            'cdg-studio-settings',
            CDG_STUDIO_URL . 'app/Modules/Settings/Assets/settings.js',
            [],
            CDG_STUDIO_VERSION,
            true
        );
    }
}