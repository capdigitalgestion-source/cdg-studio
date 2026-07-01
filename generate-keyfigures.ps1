$base = "app\Modules\KeyFigures"

New-Item -ItemType Directory -Force "$base\Assets" | Out-Null
New-Item -ItemType Directory -Force "$base\Repositories" | Out-Null
New-Item -ItemType Directory -Force "$base\Views" | Out-Null

@'
<?php

declare(strict_types=1);

namespace CDGStudio\Modules\KeyFigures;

use CDGStudio\Core\AbstractModule;

final class KeyFiguresModule extends AbstractModule
{
    private const MENU_SLUG = 'cdg-studio-key-figures';

    public function register(): void
    {
        $this->container->set('key_figures.repository', fn () => new Repositories\KeyFiguresRepository());

        $this->container->set(
            'key_figures.service',
            fn () => new KeyFiguresService($this->container->get('key_figures.repository'))
        );

        $this->container->set(
            'key_figures.controller',
            fn () => new KeyFiguresController($this->container->get('key_figures.service'))
        );
    }

    public function boot(): void
    {
        $this->hooks()->action('admin_menu', [$this, 'registerMenu']);
        $this->hooks()->action('admin_enqueue_scripts', [$this, 'enqueueAssets']);
    }

    public function registerMenu(): void
    {
        $controller = $this->container->get('key_figures.controller');

        add_submenu_page(
            'cdg-studio',
            'Chiffres clés',
            'Chiffres clés',
            'manage_options',
            self::MENU_SLUG,
            [$controller, 'index']
        );
    }

    public function enqueueAssets(string $hook): void
    {
        if (! str_contains($hook, self::MENU_SLUG)) {
            return;
        }

        wp_enqueue_style(
            'cdg-studio-key-figures',
            CDG_STUDIO_URL . 'app/Modules/KeyFigures/Assets/key-figures.css',
            [],
            CDG_STUDIO_VERSION
        );
    }
}
'@ | Set-Content "$base\KeyFiguresModule.php" -Encoding UTF8

@'
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
            wp_die(esc_html__('Accès non autorisé.', 'cdg-studio'));
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

            add_settings_error('cdg_key_figures', 'saved', __('Chiffre clé enregistré.', 'cdg-studio'), 'success');
        }

        if ($action === 'delete') {
            $this->service->delete(sanitize_text_field((string) ($_POST['id'] ?? '')));
            add_settings_error('cdg_key_figures', 'deleted', __('Chiffre clé supprimé.', 'cdg-studio'), 'success');
        }

        if ($action === 'import' && isset($_FILES['json_file']['tmp_name'])) {
            $content = file_get_contents($_FILES['json_file']['tmp_name']);
            $this->service->importJson((string) $content);
            add_settings_error('cdg_key_figures', 'imported', __('Import JSON terminé.', 'cdg-studio'), 'success');
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
'@ | Set-Content "$base\KeyFiguresController.php" -Encoding UTF8

@'
<?php

declare(strict_types=1);

namespace CDGStudio\Modules\KeyFigures;

use CDGStudio\Modules\KeyFigures\Repositories\KeyFiguresRepository;

final class KeyFiguresService
{
    public function __construct(
        private KeyFiguresRepository $repository
    ) {
    }

    public function all(): array
    {
        return $this->repository->all();
    }

    public function save(array $data): void
    {
        if (($data['title'] ?? '') === '') {
            return;
        }

        $id = $data['id'] !== '' ? $data['id'] : uniqid('kf_', true);

        $figure = [
            'id'       => $id,
            'title'    => $data['title'],
            'value'    => $data['value'] ?? '',
            'unit'     => $data['unit'] ?? '',
            'category' => $data['category'] ?? '',
        ];

        $this->repository->save($figure);
    }

    public function delete(string $id): void
    {
        $this->repository->delete($id);
    }

    public function importJson(string $json): void
    {
        $data = json_decode($json, true);

        if (! is_array($data)) {
            return;
        }

        foreach ($data as $figure) {
            if (! is_array($figure) || empty($figure['title'])) {
                continue;
            }

            $this->repository->save([
                'id'       => sanitize_text_field((string) ($figure['id'] ?? uniqid('kf_', true))),
                'title'    => sanitize_text_field((string) ($figure['title'] ?? '')),
                'value'    => sanitize_text_field((string) ($figure['value'] ?? '')),
                'unit'     => sanitize_text_field((string) ($figure['unit'] ?? '')),
                'category' => sanitize_text_field((string) ($figure['category'] ?? '')),
            ]);
        }
    }
}
'@ | Set-Content "$base\KeyFiguresService.php" -Encoding UTF8

@'
<?php

declare(strict_types=1);

namespace CDGStudio\Modules\KeyFigures\Repositories;

final class KeyFiguresRepository
{
    private const OPTION_KEY = 'cdg_studio_key_figures';

    public function all(): array
    {
        $figures = get_option(self::OPTION_KEY, []);

        return is_array($figures) ? $figures : [];
    }

    public function save(array $figure): void
    {
        $figures = $this->all();
        $figures[$figure['id']] = $figure;

        update_option(self::OPTION_KEY, $figures);
    }

    public function delete(string $id): void
    {
        $figures = $this->all();

        unset($figures[$id]);

        update_option(self::OPTION_KEY, $figures);
    }
}
'@ | Set-Content "$base\Repositories\KeyFiguresRepository.php" -Encoding UTF8

@'
<?php

defined('ABSPATH') || exit;

?>

<div class="wrap cdg-key-figures">
    <h1>Chiffres clés</h1>

    <?php settings_errors('cdg_key_figures'); ?>

    <div class="cdg-kf-actions">
        <a class="button button-secondary" href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=cdg-studio-key-figures&export=json'), 'cdg_key_figures_export')); ?>">
            Exporter JSON
        </a>
    </div>

    <h2>Ajouter un chiffre clé</h2>

    <form method="post" enctype="multipart/form-data" class="cdg-kf-form">
        <?php wp_nonce_field('cdg_key_figures_action'); ?>
        <input type="hidden" name="action_type" value="save">

        <input type="hidden" name="id" value="">

        <table class="form-table">
            <tr>
                <th><label for="title">Libellé</label></th>
                <td><input type="text" id="title" name="title" class="regular-text" required></td>
            </tr>
            <tr>
                <th><label for="value">Valeur</label></th>
                <td><input type="text" id="value" name="value" class="regular-text"></td>
            </tr>
            <tr>
                <th><label for="unit">Unité</label></th>
                <td><input type="text" id="unit" name="unit" class="regular-text" placeholder="€, %, h, jours..."></td>
            </tr>
            <tr>
                <th><label for="category">Catégorie</label></th>
                <td><input type="text" id="category" name="category" class="regular-text"></td>
            </tr>
        </table>

        <?php submit_button('Ajouter le chiffre clé'); ?>
    </form>

    <h2>Import JSON</h2>

    <form method="post" enctype="multipart/form-data">
        <?php wp_nonce_field('cdg_key_figures_action'); ?>
        <input type="hidden" name="action_type" value="import">
        <input type="file" name="json_file" accept="application/json">
        <?php submit_button('Importer JSON', 'secondary'); ?>
    </form>

    <h2>Liste des chiffres clés</h2>

    <table class="widefat striped">
        <thead>
            <tr>
                <th>Libellé</th>
                <th>Valeur</th>
                <th>Unité</th>
                <th>Catégorie</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($figures === []): ?>
                <tr>
                    <td colspan="5">Aucun chiffre clé pour le moment.</td>
                </tr>
            <?php endif; ?>

            <?php foreach ($figures as $figure): ?>
                <tr>
                    <td><?php echo esc_html((string) $figure['title']); ?></td>
                    <td><?php echo esc_html((string) $figure['value']); ?></td>
                    <td><?php echo esc_html((string) $figure['unit']); ?></td>
                    <td><?php echo esc_html((string) $figure['category']); ?></td>
                    <td>
                        <form method="post">
                            <?php wp_nonce_field('cdg_key_figures_action'); ?>
                            <input type="hidden" name="action_type" value="delete">
                            <input type="hidden" name="id" value="<?php echo esc_attr((string) $figure['id']); ?>">
                            <?php submit_button('Supprimer', 'delete small', '', false); ?>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
'@ | Set-Content "$base\Views\index.php" -Encoding UTF8

@'
.cdg-key-figures .cdg-kf-actions {
    margin: 20px 0;
}

.cdg-key-figures .cdg-kf-form {
    background: #fff;
    border: 1px solid #dcdcde;
    padding: 16px;
    margin-bottom: 24px;
}
'@ | Set-Content "$base\Assets\key-figures.css" -Encoding UTF8

@'
<?php

declare(strict_types=1);

namespace CDGStudio\Core;

use CDGStudio\Modules\Dashboard\DashboardModule;
use CDGStudio\Modules\KeyFigures\KeyFiguresModule;

final class ModuleRegistry
{
    /**
     * @return array<class-string>
     */
    public static function all(): array
    {
        return [
            DashboardModule::class,
            KeyFiguresModule::class,
        ];
    }
}
'@ | Set-Content "app\Core\ModuleRegistry.php" -Encoding UTF8