<?php

declare(strict_types=1);

namespace CDGStudio\Core;

use CDGStudio\Modules\Dashboard\DashboardModule;
use CDGStudio\Modules\KeyFigures\KeyFiguresModule;
use CDGStudio\Modules\Settings\SettingsModule;

final class ModuleRegistry
{
    /**
     * @return array<class-string>
     */
    public static function all(): array
    {
        return [
            DashboardModule::class,
            SettingsModule::class,
            KeyFiguresModule::class,
        ];
    }
}