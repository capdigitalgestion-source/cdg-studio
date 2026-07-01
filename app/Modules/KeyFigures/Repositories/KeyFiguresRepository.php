<?php

declare(strict_types=1);

namespace CDGStudio\Modules\KeyFigures\Repositories;

final class KeyFiguresRepository
{
    private const OPTION_KEY = 'cdg_studio_key_figures';

    public function all(): array
    {
        $figures = get_option(self::OPTION_KEY, []);

        return is_array($figures) ? $figures : [];
    }

    public function save(array $figure): void
    {
        $figures = $this->all();
        $figures[$figure['id']] = $figure;

        update_option(self::OPTION_KEY, $figures);
    }

    public function delete(string $id): void
    {
        $figures = $this->all();

        unset($figures[$id]);

        update_option(self::OPTION_KEY, $figures);
    }
}
