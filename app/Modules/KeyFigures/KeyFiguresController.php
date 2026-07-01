<?php

declare(strict_types=1);

namespace CDGStudio\Modules\KeyFigures;

final class KeyFiguresController
{
    public function __construct(
        private KeyFiguresService $service
    ) {
    }

    public function index(): void
    {
        if (! current_user_can('manage_options')) {
            wp_die(esc_html__('AccÃ¨s non autorisÃ©.', 'cdg-studio'));
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handlePost();
        }

        if (isset($_GET['export']) && $_GET['export'] === 'json') {
            $this->exportJson();
            return;
        }

        $figures = $this->service->all();

        require __DIR__ . '/Views/index.php';
    }

    private function handlePost(): void
    {
        check_admin_referer('cdg_key_figures_action');

        $action = sanitize_text_field((string) ($_POST['action_type'] ?? ''));

        if ($action === 'save') {
            $this->service->save([
                'id'       => sanitize_text_field((string) ($_POST['id'] ?? '')),
                'title'    => sanitize_text_field((string) ($_POST['title'] ?? '')),
                'value'    => sanitize_text_field((string) ($_POST['value'] ?? '')),
                'unit'     => sanitize_text_field((string) ($_POST['unit'] ?? '')),
                'category' => sanitize_text_field((string) ($_POST['category'] ?? '')),
            ]);

            add_settings_error('cdg_key_figures', 'saved', __('Chiffre clÃ© enregistrÃ©.', 'cdg-studio'), 'success');
        }

        if ($action === 'delete') {
            $this->service->delete(sanitize_text_field((string) ($_POST['id'] ?? '')));
            add_settings_error('cdg_key_figures', 'deleted', __('Chiffre clÃ© supprimÃ©.', 'cdg-studio'), 'success');
        }

        if ($action === 'import' && isset($_FILES['json_file']['tmp_name'])) {
            $content = file_get_contents($_FILES['json_file']['tmp_name']);
            $this->service->importJson((string) $content);
            add_settings_error('cdg_key_figures', 'imported', __('Import JSON terminÃ©.', 'cdg-studio'), 'success');
        }
    }

    private function exportJson(): void
    {
        check_admin_referer('cdg_key_figures_export');

        header('Content-Type: application/json; charset=utf-8');
        header('Content-Disposition: attachment; filename="cdg-key-figures.json"');

        echo wp_json_encode($this->service->all(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        exit;
    }
}
