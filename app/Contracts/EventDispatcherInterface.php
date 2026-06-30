<?php

declare(strict_types=1);

namespace CDGStudio\Contracts;

interface EventDispatcherInterface
{
    public function listen(string $eventClass, callable $listener): void;

    public function dispatch(object $event): object;
}