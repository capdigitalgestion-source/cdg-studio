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
        $this->index();
    }

    public function index(): void
    {
        $figures = $this->service->getAll();
        $total = $this->service->countAll();
        $visible = $this->service->countVisible();
        $hidden = $this->service->countHidden();

        require __DIR__ . '/Views/index.php';
    }

    public function store(array $data): int
    {
        return $this->service->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return $this->service->update($id, $data);
    }

    public function destroy(int $id): bool
    {
        return $this->service->delete($id);
    }
}