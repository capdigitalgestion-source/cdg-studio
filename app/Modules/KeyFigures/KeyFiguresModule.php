<?php

declare(strict_types=1);

namespace CDGStudio\Modules\KeyFigures;

use CDGStudio\Contracts\ModuleInterface;

final class KeyFiguresModule implements ModuleInterface
{
    public function register(): void
    {
        add_action('admin_menu', [$this, 'registerAdminMenu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueueAdminAssets']);
    }

    public function boot(): void
    {
        $repository = new KeyFiguresRepository();

        $repository->install();
        $repository->insertDemoDataIfNeeded();
    }

    public function registerAdminMenu(): void
    {
        add_submenu_page(
            'cdg-studio',
            'Key Figures',
            'Key Figures',
            'manage_options',
            'cdg-studio-key-figures',
            [$this, 'renderAdminPage']
        );
    }

    public function enqueueAdminAssets(string $hook): void
    {
        if ($hook !== 'cdg-studio_page_cdg-studio-key-figures') {
            return;
        }

        wp_enqueue_style(
            'cdg-key-figures-admin',
            plugins_url('assets/admin.css', __FILE__),
            [],
            '1.0.0'
        );
    }

    public function renderAdminPage(): void
    {
        $controller = new KeyFiguresController();
        $controller->index();
    }
}