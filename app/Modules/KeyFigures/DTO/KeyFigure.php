<?php

declare(strict_types=1);

namespace CDGStudio\Modules\KeyFigures\DTO;

final readonly class KeyFigure
{
    public function __construct(
        public int $id,
        public string $slug,
        public string $title,
        public string $description,
        public int $categoryId,
        public string $unit,
        public float $targetValue = 0,
        public bool $visible = true,
        public bool $editable = true,
        public int $order = 0,
    ) {
    }
}