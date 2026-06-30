<?php

declare(strict_types=1);

namespace CDGStudio\Core;

/**
 * Chargeur principal de CDG Studio.
 */
final class Loader
{
    private Application $application;

    public function __construct()
    {
        $this->application = new Application();
    }

    public function boot(): void
    {
        $this->application->boot();
    }
}