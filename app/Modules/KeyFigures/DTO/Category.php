<?php

declare(strict_types=1);

namespace CDGStudio\Modules\KeyFigures\DTO;

final readonly class Category
{
    public function __construct(
        public int $id,
        public string $slug,
        public string $title,
        public string $icon = '',
        public string $color = '#2271b1',
        public int $order = 0,
    ) {
    }
}