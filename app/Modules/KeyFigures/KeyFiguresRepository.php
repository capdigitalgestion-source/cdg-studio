<?php

declare(strict_types=1);

namespace CDGStudio\Modules\KeyFigures\Repositories;

final class KeyFiguresRepository
{
    private string $tableName;

    public function __construct()
    {
        global $wpdb;

        $this->tableName = $wpdb->prefix . 'cdg_key_figures';
    }

    public function install(): void
    {
        global $wpdb;

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        $charsetCollate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE {$this->tableName} (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            title VARCHAR(190) NOT NULL,
            value VARCHAR(100) NOT NULL,
            unit VARCHAR(50) NULL,
            description TEXT NULL,
            position INT UNSIGNED NOT NULL DEFAULT 0,
            is_active TINYINT(1) NOT NULL DEFAULT 1,
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME NULL DEFAULT NULL,
            PRIMARY KEY (id)
        ) {$charsetCollate};";

        dbDelta($sql);
    }

    public function insertDemoDataIfNeeded(): void
    {
        if (get_option('cdg_key_figures_demo_inserted') === 'yes') {
            return;
        }

        if ($this->count() > 0) {
            update_option('cdg_key_figures_demo_inserted', 'yes');
            return;
        }

        $this->create([
            'title' => 'Clients accompagnés',
            'value' => '120',
            'unit' => '+',
            'description' => 'Exemple de donnée de démonstration.',
            'position' => 1,
            'is_active' => 1,
        ]);

        $this->create([
            'title' => 'Projets digitalisation',
            'value' => '45',
            'unit' => '+',
            'description' => 'Exemple de donnée de démonstration.',
            'position' => 2,
            'is_active' => 1,
        ]);

        $this->create([
            'title' => 'Années d’expérience',
            'value' => '8',
            'unit' => '+',
            'description' => 'Exemple de donnée de démonstration.',
            'position' => 3,
            'is_active' => 1,
        ]);

        update_option('cdg_key_figures_demo_inserted', 'yes');
    }

    public function all(): array
    {
        global $wpdb;

        return $wpdb->get_results(
            "SELECT * FROM {$this->tableName} ORDER BY position ASC, id ASC",
            ARRAY_A
        ) ?: [];
    }

    public function active(): array
    {
        global $wpdb;

        return $wpdb->get_results(
            "SELECT * FROM {$this->tableName} WHERE is_active = 1 ORDER BY position ASC, id ASC",
            ARRAY_A
        ) ?: [];
    }

    public function find(int $id): ?array
    {
        global $wpdb;

        $result = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM {$this->tableName} WHERE id = %d",
                $id
            ),
            ARRAY_A
        );

        return $result ?: null;
    }

    public function create(array $data): int
    {
        global $wpdb;

        $wpdb->insert(
            $this->tableName,
            [
                'title' => sanitize_text_field($data['title'] ?? ''),
                'value' => sanitize_text_field($data['value'] ?? ''),
                'unit' => sanitize_text_field($data['unit'] ?? ''),
                'description' => sanitize_textarea_field($data['description'] ?? ''),
                'position' => absint($data['position'] ?? 0),
                'is_active' => !empty($data['is_active']) ? 1 : 0,
                'created_at' => current_time('mysql'),
                'updated_at' => current_time('mysql'),
            ],
            ['%s', '%s', '%s', '%s', '%d', '%d', '%s', '%s']
        );

        return (int) $wpdb->insert_id;
    }

    public function update(int $id, array $data): bool
    {
        global $wpdb;

        $updated = $wpdb->update(
            $this->tableName,
            [
                'title' => sanitize_text_field($data['title'] ?? ''),
                'value' => sanitize_text_field($data['value'] ?? ''),
                'unit' => sanitize_text_field($data['unit'] ?? ''),
                'description' => sanitize_textarea_field($data['description'] ?? ''),
                'position' => absint($data['position'] ?? 0),
                'is_active' => !empty($data['is_active']) ? 1 : 0,
                'updated_at' => current_time('mysql'),
            ],
            ['id' => $id],
            ['%s', '%s', '%s', '%s', '%d', '%d', '%s'],
            ['%d']
        );

        return $updated !== false;
    }

    public function delete(int $id): bool
    {
        global $wpdb;

        return $wpdb->delete(
            $this->tableName,
            ['id' => $id],
            ['%d']
        ) !== false;
    }

    public function count(): int
    {
        global $wpdb;

        return (int) $wpdb->get_var("SELECT COUNT(*) FROM {$this->tableName}");
    }
}