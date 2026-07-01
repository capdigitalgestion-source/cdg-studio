<?php

declare(strict_types=1);

namespace CDGStudio\Modules\KeyFigures;

use wpdb;

final class KeyFiguresRepository
{
    public function __construct(
        private readonly wpdb $database
    ) {
    }

    public function tableName(): string
    {
        return $this->database->prefix . 'cdg_studio_key_figures';
    }

    public function install(): void
    {
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        $tableName = $this->tableName();
        $charsetCollate = $this->database->get_charset_collate();

        $sql = "CREATE TABLE {$tableName} (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            label VARCHAR(191) NOT NULL,
            value VARCHAR(100) NOT NULL,
            suffix VARCHAR(50) DEFAULT '',
            icon VARCHAR(100) DEFAULT '',
            color VARCHAR(20) DEFAULT '',
            display_order INT UNSIGNED DEFAULT 0,
            is_visible TINYINT(1) DEFAULT 1,
            animation VARCHAR(100) DEFAULT '',
            created_at DATETIME NOT NULL,
            updated_at DATETIME NULL,
            PRIMARY KEY  (id)
        ) {$charsetCollate};";

        dbDelta($sql);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function findAll(): array
    {
        return $this->fakeData();
    }

    public function findById(int $id): ?array
    {
        foreach ($this->fakeData() as $figure) {
            if ((int) $figure['id'] === $id) {
                return $figure;
            }
        }

        return null;
    }

    public function create(array $data): int
    {
        return 0;
    }

    public function update(int $id, array $data): bool
    {
        return false;
    }

    public function delete(int $id): bool
    {
        return false;
    }

    public function countAll(): int
    {
        return count($this->findAll());
    }

    public function countVisible(): int
    {
        return count(array_filter(
            $this->findAll(),
            static fn (array $figure): bool => (bool) ($figure['is_visible'] ?? false)
        ));
    }

    public function countHidden(): int
    {
        return $this->countAll() - $this->countVisible();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function fakeData(): array
    {
        return [
            [
                'id' => 1,
                'label' => 'Clients accompagnés',
                'value' => '24',
                'suffix' => '+',
                'icon' => 'dashicons-groups',
                'color' => '#002C73',
                'display_order' => 1,
                'is_visible' => true,
                'animation' => 'count-up',
            ],
            [
                'id' => 2,
                'label' => 'Diagnostics réalisés',
                'value' => '42',
                'suffix' => '',
                'icon' => 'dashicons-chart-bar',
                'color' => '#0094AA',
                'display_order' => 2,
                'is_visible' => true,
                'animation' => 'count-up',
            ],
            [
                'id' => 3,
                'label' => 'Gain de temps estimé',
                'value' => '30',
                'suffix' => '%',
                'icon' => 'dashicons-clock',
                'color' => '#00ADBD',
                'display_order' => 3,
                'is_visible' => true,
                'animation' => 'count-up',
            ],
        ];
    }
}