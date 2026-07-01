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
     * Retourne les chiffres clés préparés pour l’affichage.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getAll(): array
    {
        return $this->repository->all();
    }

    public function countAll(): int
    {
        return count($this->getAll());
    }

    public function countVisible(): int
    {
        return count(array_filter(
            $this->getAll(),
            static fn (array $figure): bool => (bool) ($figure['visible'] ?? false)
        ));
    }

    public function countHidden(): int
    {
        return $this->countAll() - $this->countVisible();
    }
}