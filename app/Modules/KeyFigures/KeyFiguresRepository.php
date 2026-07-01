<?php

declare(strict_types=1);

namespace CDGStudio\Modules\KeyFigures;

final class KeyFiguresRepository
{
    /**
     * Retourne les chiffres clés.
     *
     * Pour l’instant, données temporaires.
     * La persistance en base sera ajoutée dans une étape dédiée.
     *
     * @return array<int, array<string, mixed>>
     */
    public function all(): array
    {
        return [
            [
                'id' => 1,
                'label' => 'Chiffres clés',
                'value' => 4,
                'visible' => true,
            ],
            [
                'id' => 2,
                'label' => 'Visibles',
                'value' => 4,
                'visible' => true,
            ],
            [
                'id' => 3,
                'label' => 'Masqués',
                'value' => 0,
                'visible' => false,
            ],
        ];
    }
}