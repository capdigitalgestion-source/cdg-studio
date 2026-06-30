<?php

declare(strict_types=1);

namespace CDGStudio\Modules\Dashboard;

use CDGStudio\Core\AbstractModule;

final class DashboardModule extends AbstractModule
{
    public function register(): void
    {
        // Enregistrement des services du module Dashboard.
    }

    public function boot(): void
    {
        $this->logger()->info('DashboardModule boot OK');
    }
}