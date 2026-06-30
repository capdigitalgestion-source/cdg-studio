<?php

declare(strict_types=1);

namespace CDGStudio\Modules\Dashboard;

use CDGStudio\Core\AbstractModule;

final class DashboardModule extends AbstractModule
{
    private const MENU_SLUG = 'cdg-studio';

    public function register(): void
    {
        $this->container->set(
            'dashboard.service',
            fn () => new DashboardService($this->container)
        );

        $this->container->set(
            'dashboard.controller',
            fn () => new DashboardController(
                $this->container->get('dashboard.service')
            )
        );
    }

    public function boot(): void
    {
        $this->hooks()->action('admin_menu', [$this, 'registerMenu']);

        $this->logger()->info('DashboardModule boot OK');
    }

    public function registerMenu(): void
    {
        /** @var DashboardController $controller */
        $controller = $this->container->get('dashboard.controller');

        add_submenu_page(
            self::MENU_SLUG,
            'Diagnostic Framework',
            'Diagnostic Framework',
            'manage_options',
            'cdg-studio-dashboard',
            [$controller, 'render']
        );
    }
}