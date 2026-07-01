<?php

declare(strict_types=1);

namespace CDGStudio\Modules\KeyFigures;

use CDGStudio\Core\AbstractModule;

final class KeyFiguresModule extends AbstractModule
{
    private const MENU_SLUG = 'cdg-studio-key-figures';

    public function register(): void
    {
        $this->container->set('key_figures.repository', fn () => new Repositories\KeyFiguresRepository());

        $this->container->set(
            'key_figures.service',
            fn () => new KeyFiguresService($this->container->get('key_figures.repository'))
        );

        $this->container->set(
            'key_figures.controller',
            fn () => new KeyFiguresController($this->container->get('key_figures.service'))
        );
    }

    public function boot(): void
    {
        $this->hooks()->action('admin_menu', [$this, 'registerMenu']);
        $this->hooks()->action('admin_enqueue_scripts', [$this, 'enqueueAssets']);
    }

    public function registerMenu(): void
    {
        $controller = $this->container->get('key_figures.controller');

        add_submenu_page(
            'cdg-studio',
            'Chiffres clÃ©s',
            'Chiffres clÃ©s',
            'manage_options',
            self::MENU_SLUG,
            [$controller, 'index']
        );
    }

    public function enqueueAssets(string $hook): void
    {
        if (! str_contains($hook, self::MENU_SLUG)) {
            return;
        }

        wp_enqueue_style(
            'cdg-studio-key-figures',
            CDG_STUDIO_URL . 'app/Modules/KeyFigures/Assets/key-figures.css',
            [],
            CDG_STUDIO_VERSION
        );
    }
}
