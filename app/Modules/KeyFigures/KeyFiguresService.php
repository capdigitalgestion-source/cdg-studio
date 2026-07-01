<?php

declare(strict_types=1);

namespace CDGStudio\Modules\KeyFigures;

final class KeyFiguresService
{
    public function __construct(
        private readonly KeyFiguresRepository $repository
    ) {
    }

    public function install(): void
    {
        $this->repository->install();
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
        $data = $this->sanitize($data);

        if (! $this->isValid($data)) {
            return 0;
        }

        return $this->repository->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $data = $this->sanitize($data);

        if (! $this->isValid($data)) {
            return false;
        }

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

    /**
     * @return array<string, mixed>
     */
    private function sanitize(array $data): array
    {
        return [
            'label' => sanitize_text_field((string) ($data['label'] ?? '')),
            'value' => sanitize_text_field((string) ($data['value'] ?? '')),
            'suffix' => sanitize_text_field((string) ($data['suffix'] ?? '')),
            'icon' => sanitize_text_field((string) ($data['icon'] ?? '')),
            'color' => sanitize_hex_color((string) ($data['color'] ?? '')) ?: '',
            'display_order' => absint($data['display_order'] ?? 0),
            'is_visible' => ! empty($data['is_visible']),
            'animation' => sanitize_text_field((string) ($data['animation'] ?? '')),
        ];
    }

    private function isValid(array $data): bool
    {
        return $data['label'] !== ''
            && $data['value'] !== '';
    }
}