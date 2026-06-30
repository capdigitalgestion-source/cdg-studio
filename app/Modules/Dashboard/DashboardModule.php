<?php

declare(strict_types=1);

namespace CDGStudio\Modules\Dashboard;

use CDGStudio\Contracts\ModuleInterface;

final class DashboardModule implements ModuleInterface
{
    public function register(): void
    {
        // Enregistrement des services du module.
    }

    public function boot(): void
    {
        // Démarrage du module.
    }
}