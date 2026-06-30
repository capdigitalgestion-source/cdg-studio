<?php

declare(strict_types=1);

namespace CDGStudio\Core;

use CDGStudio\Modules\Dashboard\DashboardModule;

final class ModuleRegistry
{
    /**
     * Retourne la liste officielle des modules du Framework.
     *
     * @return array<class-string>
     */
    public static function all(): array
    {
        return [
            DashboardModule::class,
        ];
    }
}