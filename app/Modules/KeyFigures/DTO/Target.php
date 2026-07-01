<?php

declare(strict_types=1);

namespace CDGStudio\Modules\KeyFigures\DTO;

final readonly class Target
{
    public function __construct(
        public int $id,
        public int $keyFigureId,
        public float $value,
        public string $startDate,
        public string $endDate,
    ) {
    }
}