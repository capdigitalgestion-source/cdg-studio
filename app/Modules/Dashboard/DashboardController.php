<?php

declare(strict_types=1);

namespace CDGStudio\Modules\Dashboard;

use CDGStudio\Core\ConfigManager;
use CDGStudio\Core\ModuleLoader;
use CDGStudio\Support\Container;

final class DashboardService
{
    public function __construct(
        private Container $container
    ) {
    }

    public function data(): array
    {
        /** @var ConfigManager $config */
        $config = $this->container->get('config');

        /** @var ModuleLoader $modules */
        $modules = $this->container->get('modules');

        return [
            'plugin_version' => $config->get('version', '0.0.0'),
            'db_version'     => $config->get('db_version', '0.0.0'),
            'modules_count'  => count($modules->all()),
            'modules'        => array_map(
                static fn (object $module): string => $module::class,
                $modules->all()
            ),
            'services'       => [
                'config',
                'logger',
                'events',
                'hooks',
                'cache',
                'settings',
                'modules',
            ],
        ];
    }
}