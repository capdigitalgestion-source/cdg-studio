<?php

declare(strict_types=1);

namespace CDGStudio\Contracts;

use CDGStudio\Modules\Settings\SettingsRegistry;

interface SettingsProviderInterface
{
    public function register(SettingsRegistry $registry): void;
}