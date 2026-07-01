<?php

declare(strict_types=1);

namespace CDGStudio\Modules\KeyFigures;

use CDGStudio\Contracts\ModuleInterface;
use CDGStudio\Modules\KeyFigures\KeyFiguresRepository;

final class KeyFiguresModule implements ModuleInterface
{
    public function register(): void
    {
        $repository = new KeyFiguresRepository();

        $repository->install();
        $repository->insertDemoDataIfNeeded();
    }
}