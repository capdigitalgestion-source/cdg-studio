<?php

declare(strict_types=1);

namespace CDGStudio\Modules\KeyFigures\DTO;

final readonly class Widget
{
    public function __construct(
        public string $type,
        public int $keyFigureId,
        public int $width = 1,
        public int $height = 1,
    ) {
    }
}