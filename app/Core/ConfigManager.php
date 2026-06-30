<?php

namespace CDGStudio\Core;

defined('ABSPATH') || exit;

class ConfigManager
{
    private array $config = [];

    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->config[$key] ?? $default;
    }

    public function set(string $key, mixed $value): void
    {
        $this->config[$key] = $value;
    }

    public function all(): array
    {
        return $this->config;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->config);
    }
}