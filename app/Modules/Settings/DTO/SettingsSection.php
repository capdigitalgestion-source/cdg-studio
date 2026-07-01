<?php

declare(strict_types=1);

namespace CDGStudio\Modules\Settings\DTO;

final class SettingsSection
{
    public function __construct(
        public readonly string $id,
        public readonly string $title,
        public readonly string $description = '',
        public readonly string $icon = '',
        public readonly int $order = 100
    ) {
    }
}