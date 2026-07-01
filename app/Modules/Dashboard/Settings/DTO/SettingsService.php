<?php

declare(strict_types=1);

namespace CDGStudio\Modules\Settings;

use CDGStudio\Modules\Settings\DTO\SettingsField;

final class SettingsService
{
    private const OPTION_KEY = 'cdg_studio_settings';

    public function __construct(
        private SettingsRegistry $registry
    ) {
    }

    public function all(): array
    {
        $stored = get_option(self::OPTION_KEY, []);

        if (! is_array($stored)) {
            $stored = [];
        }

        $settings = [];

        foreach ($this->registry->fields() as $field) {
            $settings[$field->key] = $stored[$field->key] ?? $field->default;
        }

        return $settings;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->all()[$key] ?? $default;
    }

    public function save(array $input): void
    {
        $settings = [];

        foreach ($this->registry->fields() as $field) {
            $settings[$field->key] = $this->sanitizeField($field, $input[$field->key] ?? null);
        }

        update_option(self::OPTION_KEY, $settings);
    }

    private function sanitizeField(SettingsField $field, mixed $value): mixed
    {
        return match ($field->type) {
            'checkbox' => (bool) $value,
            'number'   => is_numeric($value) ? (int) $value : (int) $field->default,
            'select'   => array_key_exists((string) $value, $field->choices)
                ? (string) $value
                : $field->default,
            default    => sanitize_text_field((string) $value),
        };
    }
}