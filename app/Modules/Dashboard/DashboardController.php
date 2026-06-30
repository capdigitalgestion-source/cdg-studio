<?php

declare(strict_types=1);

namespace CDGStudio\Modules\Dashboard;

final class DashboardController
{
    public function __construct(
        private DashboardService $service
    ) {
    }

    public function render(): void
    {
        if (! current_user_can('manage_options')) {
            wp_die(esc_html__('Accès non autorisé.', 'cdg-studio'));
        }

        $data = $this->service->data();

        require __DIR__ . '/Views/dashboard.php';
    }
}