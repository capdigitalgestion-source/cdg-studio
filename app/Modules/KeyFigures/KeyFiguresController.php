<?php

declare(strict_types=1);

namespace CDGStudio\Modules\KeyFigures;

final class KeyFiguresController
{
    private KeyFiguresService $service;

    public function __construct()
    {
        $this->service = new KeyFiguresService();
    }

    public function index(): void
    {
        if (!current_user_can('manage_options')) {
            wp_die(__('Accès refusé.', 'cdg-studio'));
        }

        $this->handleActions();

        $figures = $this->service->getAll();

        require __DIR__ . '/Views/index.php';
    }

    private function handleActions(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        check_admin_referer('cdg_key_figures_action', 'cdg_key_figures_nonce');

        $action = sanitize_text_field(wp_unslash($_POST['cdg_action'] ?? ''));

        if ($action === 'create') {
            $this->service->create(wp_unslash($_POST));
            $this->redirectWithMessage('created');
        }

        if ($action === 'update') {
            $id = absint($_POST['id'] ?? 0);

            if ($id > 0) {
                $this->service->update($id, wp_unslash($_POST));
            }

            $this->redirectWithMessage('updated');
        }

        if ($action === 'delete') {
            $id = absint($_POST['id'] ?? 0);

            if ($id > 0) {
                $this->service->delete($id);
            }

            $this->redirectWithMessage('deleted');
        }
    }

    private function redirectWithMessage(string $message): void
    {
        wp_safe_redirect(
            add_query_arg(
                [
                    'page' => 'cdg-studio-key-figures',
                    'message' => $message,
                ],
                admin_url('admin.php')
            )
        );

        exit;
    }
}