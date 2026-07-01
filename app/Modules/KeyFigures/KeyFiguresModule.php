<?php

declare(strict_types=1);

namespace CDGStudio\Modules\KeyFigures;

use CDGStudio\Contracts\ModuleInterface;

final class KeyFiguresModule implements ModuleInterface
{
    public function register(): void
    {
        add_action('admin_menu', [$this, 'registerAdminMenu']);
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

    public function renderAdminPage(): void
    {
        $controller = new KeyFiguresController();
        $controller->index();
    }
}