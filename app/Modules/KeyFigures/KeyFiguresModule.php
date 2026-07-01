<?php

declare(strict_types=1);

namespace CDGStudio\Modules\KeyFigures;

use CDGStudio\Core\AbstractModule;

final class KeyFiguresModule extends AbstractModule
{
    private const MENU_SLUG = 'cdg-studio';

    public function register(): void
    {
        $this->container->set(
            'keyfigures.repository',
            fn () => new KeyFiguresRepository($GLOBALS['wpdb'])
        );

        $this->container->set(
            'keyfigures.service',
            fn () => new KeyFiguresService(
                $this->container->get('keyfigures.repository')
            )
        );

        $this->container->set(
            'keyfigures.controller',
            fn () => new KeyFiguresController(
                $this->container->get('keyfigures.service')
            )
        );
    }

    public function boot(): void
    {
        $this->hooks()->action('admin_menu', [$this, 'registerMenu']);

        $this->logger()->info('KeyFiguresModule boot OK');
    }

    public function install(): void
    {
        /** @var KeyFiguresService $service */
        $service = $this->container->get('keyfigures.service');

        $service->install();

        $this->logger()->info('KeyFiguresModule install OK');
    }

    public function registerMenu(): void
    {
        /** @var KeyFiguresController $controller */
        $controller = $this->container->get('keyfigures.controller');

        add_submenu_page(
            self::MENU_SLUG,
            'Chiffres clés',
            'Chiffres clés',
            'manage_options',
            'cdg-studio-key-figures',
            [$controller, 'render']
        );
    }
}