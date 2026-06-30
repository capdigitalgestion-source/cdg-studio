<?php

declare(strict_types=1);

namespace CDGStudio\Events;

abstract class Event
{
    private \DateTimeImmutable $occurredAt;

    public function __construct()
    {
        $this->occurredAt = new \DateTimeImmutable();
    }

    public function occurredAt(): \DateTimeImmutable
    {
        return $this->occurredAt;
    }

    public function name(): string
    {
        return static::class;
    }
}