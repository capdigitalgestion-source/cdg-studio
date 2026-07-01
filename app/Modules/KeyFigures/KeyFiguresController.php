<?php

declare(strict_types=1);

namespace CDGStudio\Modules\KeyFigures;

final class KeyFiguresController
{
    public function __construct(
        private readonly KeyFiguresService $service
    ) {
    }

    public function render(): void
    {
        $figures = $this->service->getAll();
        $total = $this->service->countAll();
        $visible = $this->service->countVisible();
        $hidden = $this->service->countHidden();

        require __DIR__ . '/Views/index.php';
    }
}