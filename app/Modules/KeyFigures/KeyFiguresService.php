<?php

declare(strict_types=1);

namespace CDGStudio\Modules\KeyFigures;

use CDGStudio\Modules\KeyFigures\Repositories\KeyFiguresRepository;

final class KeyFiguresService
{
    public function __construct(
        private KeyFiguresRepository $repository
    ) {
    }

    public function all(): array
    {
        return $this->repository->all();
    }

    public function save(array $data): void
    {
        if (($data['title'] ?? '') === '') {
            return;
        }

        $id = $data['id'] !== '' ? $data['id'] : uniqid('kf_', true);

        $figure = [
            'id'       => $id,
            'title'    => $data['title'],
            'value'    => $data['value'] ?? '',
            'unit'     => $data['unit'] ?? '',
            'category' => $data['category'] ?? '',
        ];

        $this->repository->save($figure);
    }

    public function delete(string $id): void
    {
        $this->repository->delete($id);
    }

    public function importJson(string $json): void
    {
        $data = json_decode($json, true);

        if (! is_array($data)) {
            return;
        }

        foreach ($data as $figure) {
            if (! is_array($figure) || empty($figure['title'])) {
                continue;
            }

            $this->repository->save([
                'id'       => sanitize_text_field((string) ($figure['id'] ?? uniqid('kf_', true))),
                'title'    => sanitize_text_field((string) ($figure['title'] ?? '')),
                'value'    => sanitize_text_field((string) ($figure['value'] ?? '')),
                'unit'     => sanitize_text_field((string) ($figure['unit'] ?? '')),
                'category' => sanitize_text_field((string) ($figure['category'] ?? '')),
            ]);
        }
    }
}
