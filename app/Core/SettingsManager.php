<?php

declare(strict_types=1);

namespace CDGStudio\Core;

final class SettingsManager
{
    private string $prefix;

    public function __construct(string $prefix = 'cdg_studio_')
    {
        $this->prefix = $prefix;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return get_option($this->key($key), $default);
    }

    public function set(string $key, mixed $value): bool
    {
        update_option($this->key($key), $value);

        return true;
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