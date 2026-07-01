<?php

declare(strict_types=1);

namespace CDGStudio\Modules\Settings;

final class SettingsController
{
    public function __construct(
        private SettingsService $service,
        private SettingsRegistry $registry
    ) {
    }

    public function render(): void
    {
        if (! current_user_can('manage_options')) {
            wp_die(esc_html__('Accès non autorisé.', 'cdg-studio'));
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleSave();
        }

        $settings = $this->service->all();
        $sections = $this->registry->sections();

        require __DIR__ . '/Views/settings.php';
    }

    private function handleSave(): void
    {
        check_admin_referer('cdg_studio_save_settings');

        $input = isset($_POST['cdg_studio_settings']) && is_array($_POST['cdg_studio_settings'])
            ? wp_unslash($_POST['cdg_studio_settings'])
            : [];

        $this->service->save($input);

        add_settings_error(
            'cdg_studio_settings',
            'cdg_studio_settings_saved',
            __('Réglages enregistrés.', 'cdg-studio'),
            'success'
        );
    }
}