<?php

declare(strict_types=1);

namespace CDGStudio\Support;

use CDGStudio\Contracts\EventDispatcherInterface;

final class EventDispatcher implements EventDispatcherInterface
{
    /**
     * @var array<string, list<callable>>
     */
    private array $listeners = [];

    public function listen(string $eventClass, callable $listener): void
    {
        $this->listeners[$eventClass][] = $listener;
    }

    public function dispatch(object $event): object
    {
        $eventClass = $event::class;

        foreach ($this->listeners[$eventClass] ?? [] as $listener) {
            $listener($event);
        }

        return $event;
    }
}