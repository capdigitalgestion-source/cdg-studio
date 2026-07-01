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

    public function find(int $id): ?array
    {
        return $this->repository->findById($id);
    }

    public function create(array $data): int
    {
        return $this->repository->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return $this->repository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
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