<?php

declare(strict_types=1);

namespace CDGStudio\Core;

/**
 * Classe principale du plugin.
 *
 * Cette classe pilote le cycle de vie du plugin
 * et orchestre le démarrage du Core.
 */
final class Plugin
{
    private Application $application;

    public function __construct()
    {
        $this->application = new Application();
    }

    /**
     * Lance le plugin.
     */
    public function run(): void
    {
        $this->application->boot();
    }

    /**
     * Retourne l'instance de l'application.
     */
    public function application(): Application
    {
        return $this->application;
    }
}