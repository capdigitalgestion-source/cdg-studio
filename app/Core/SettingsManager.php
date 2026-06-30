<?php

declare(strict_types=1);

namespace CDGStudio\Core;

final class SettingsManager
{
    public function __construct(
        private readonly string $prefix = 'cdg_studio_'
    ) {
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return get_option($this->key($key), $default);
    }

    public function set(string $key, mixed $value): bool
    {
        return update_option($this->key($key), $value);
    }

    public function forget(string $key): bool
    {
        return delete_option($this->key($key));
    }

    public function has(string $key): bool
    {
        return get_option($this->key($key), null) !== null;
    }

    private function key(string $key): string
    {
        return $this->prefix . sanitize_key($key);
    }
}