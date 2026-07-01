<?php

declare(strict_types=1);

namespace CDGStudio\Modules\KeyFigures\DTO;

final readonly class KeyFigureValue
{
    public function __construct(
        public int $id,
        public int $keyFigureId,
        public string $period,
        public float $value,
        public ?string $comment = null,
    ) {
    }
}