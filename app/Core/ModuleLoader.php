<?php

declare(strict_types=1);

namespace CDGStudio\Core;

use CDGStudio\Contracts\ModuleInterface;

final class ModuleLoader
{
    /**
     * @var ModuleInterface[]
     */
    private array $modules = [];

    public function add(ModuleInterface $module): void
    {
        $this->modules[] = $module;
    }

    public function register(): void
    {
        foreach ($this->modules as $module) {
            $module->register();
        }
    }

    public function boot(): void
    {
        foreach ($this->modules as $module) {
            $module->boot();
        }
    }
}