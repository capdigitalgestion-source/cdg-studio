<?php

declare(strict_types=1);

namespace CDGStudio\Modules\KeyFigures;

final class KeyFiguresService
{
    private KeyFiguresRepository $repository;

    public function __construct()
    {
        $this->repository = new KeyFiguresRepository();
    }

    public function getAll(): array
    {
        return $this->repository->all();
    }

    public function getActive(): array
    {
        return $this->repository->active();
    }

    public function getById(int $id): ?array
    {
        return $this->repository->find($id);
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
}