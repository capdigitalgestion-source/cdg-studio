<?php

declare(strict_types=1);

namespace CDGStudio\Core;

/**
 * Point d'entrée du plugin.
 */
final class Plugin
{
    public static function boot(): void
    {
        $loader = new Loader();

        $loader->boot();
    }
}