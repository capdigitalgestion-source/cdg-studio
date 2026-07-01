<?php

declare(strict_types=1);

namespace CDGStudio\Modules\KeyFigures;

final class KeyFiguresRepository
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public function findAll(): array
    {
        return $this->fakeData();
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