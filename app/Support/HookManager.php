<?php

declare(strict_types=1);

namespace CDGStudio\Support;

final class HookManager
{
    public function action(
        string $hook,
        callable $callback,
        int $priority = 10,
        int $acceptedArgs = 1
    ): void {
        add_action($hook, $callback, $priority, $acceptedArgs);
    }

    public function filter(
        string $hook,
        callable $callback,
        int $priority = 10,
        int $acceptedArgs = 1
    ): void {
        add_filter($hook, $callback, $priority, $acceptedArgs);
    }

    public function removeAction(
        string $hook,
        callable $callback,
        int $priority = 10
    ): void {
        remove_action($hook, $callback, $priority);
    }

    public function removeFilter(
        string $hook,
        callable $callback,
        int $priority = 10
    ): void {
        remove_filter($hook, $callback, $priority);
    }
}