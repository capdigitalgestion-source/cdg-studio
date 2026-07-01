<?php

declare(strict_types=1);

namespace CDGStudio\Modules\Settings\DTO;

final class SettingsField
{
    public function __construct(
        public readonly string $key,
        public readonly string $section,
        public readonly string $label,
        public readonly string $type = 'text',
        public readonly mixed $default = null,
        public readonly bool $required = false,
        public readonly array $choices = [],
        public readonly string $description = ''
    ) {
    }
}