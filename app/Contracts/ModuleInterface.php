<?php

declare(strict_types=1);

namespace CDGStudio\Contracts;

interface ModuleInterface
{
    public function register(): void;

    public function boot(): void;
}