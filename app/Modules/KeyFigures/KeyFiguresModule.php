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

    public function enqueueAdminAssets(): void
    {
        $page = isset($_GET['page']) ? sanitize_text_field(wp_unslash($_GET['page'])) : '';

        if ($page !== 'cdg-studio-key-figures') {
            return;
        }

        wp_register_style('cdg-key-figures-admin', false, [], '1.0.0');
        wp_enqueue_style('cdg-key-figures-admin');

        $cssPath = __DIR__ . '/assets/admin.css';

        if (file_exists($cssPath)) {
            wp_add_inline_style(
                'cdg-key-figures-admin',
                (string) file_get_contents($cssPath)
            );
        }
    }

    public function renderAdminPage(): void
    {
        $controller = new KeyFiguresController();
        $controller->index();
    }
}