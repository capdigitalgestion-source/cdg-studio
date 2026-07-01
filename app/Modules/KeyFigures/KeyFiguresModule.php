<?php

declare(strict_types=1);

namespace CDGStudio\Modules\KeyFigures;

use CDGStudio\Core\AbstractModule;
use CDGStudio\Modules\KeyFigures\Repositories\KeyFiguresRepository;

final class KeyFiguresModule extends AbstractModule
{
    public function getName(): string
    {
        return 'key_figures';
    }

    public function getLabel(): string
    {
        return 'Key Figures';
    }

    public function boot(): void
    {
        $repository = new KeyFiguresRepository();

        $repository->install();
        $repository->insertDemoDataIfNeeded();
    }
}