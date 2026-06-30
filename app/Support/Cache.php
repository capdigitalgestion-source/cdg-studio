<?php

declare(strict_types=1);

namespace CDGStudio\Support;

final class Cache
{
    public function get(string $key, mixed $default = null): mixed
    {
        $value = get_transient($this->key($key));

        return $value === false ? $default : $value;
    }

    public function put(string $key, mixed $value, int $seconds = 3600): void
    {
        set_transient($this->key($key), $value, $seconds);
    }

    public function forget(string $key): void
    {
        delete_transient($this->key($key));
    }

    public function remember(string $key, int $seconds, callable $callback): mixed
    {
        $value = $this->get($key);

        if ($value !== null) {
            return $value;
        }

        $value = $callback();

        $this->put($key, $value, $seconds);

        return $value;
    }

    private function key(string $key): string
    {
        return 'cdg_studio_' . sanitize_key($key);
    }
}