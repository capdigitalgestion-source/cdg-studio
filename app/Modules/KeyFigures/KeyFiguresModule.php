<?php

declare(strict_types=1);

namespace CDGStudio\Modules\KeyFigures;

use CDGStudio\Contracts\ModuleInterface;

final class KeyFiguresModule implements ModuleInterface
{
    public function register(): void
    {
        // Enregistrement des services du module si nécessaire.
    }

    public function boot(): void
    {
        $repository = new KeyFiguresRepository();

        $repository->install();
        $repository->insertDemoDataIfNeeded();
    }
}