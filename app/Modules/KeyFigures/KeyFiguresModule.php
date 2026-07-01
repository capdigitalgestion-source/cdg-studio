<?php

declare(strict_types=1);

namespace CDGStudio\Modules\KeyFigures;

use CDGStudio\Core\AbstractModule;

final class KeyFiguresModule extends AbstractModule
{
    public function name(): string
    {
        return 'key_figures';
    }

    public function register(): void
    {
        // Enregistrement des services du module KeyFigures.
    }

    public function boot(): void
    {
        // Initialisation du module KeyFigures.
    }
}