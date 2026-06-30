<?php

declare(strict_types=1);

namespace CDGStudio\Core;

final class ConfigManager
{
    public function __construct(
        private array $config = []
    ) {
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->config[$key] ?? $default;
    }

    public function set(string $key, mixed $value): void
    {
        $this->config[$key] = $value;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->config);
    }

    public function all(): array
    {
        return $this->config;
    }
}