<?php

declare(strict_types=1);

namespace CDGStudio\Modules\KeyFigures;

final class KeyFiguresService
{
    public function __construct(
        private readonly KeyFiguresRepository $repository
    ) {
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getAll(): array
    {
        return $this->repository->findAll();
    }

    public function countAll(): int
    {
        return $this->repository->countAll();
    }

    public function countVisible(): int
    {
        return $this->repository->countVisible();
    }

    public function countHidden(): int
    {
        return $this->repository->countHidden();
    }
}