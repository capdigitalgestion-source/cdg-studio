<?php

declare(strict_types=1);

namespace CDGStudio\Modules\Dashboard;

use CDGStudio\Core\ConfigManager;
use CDGStudio\Core\ModuleLoader;
use CDGStudio\Support\Container;
use Throwable;

final class DashboardService
{
    private const CORE_SERVICES = [
        'config',
        'logger',
        'events',
        'hooks',
        'cache',
        'settings',
        'modules',
    ];

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

        $loadedModules = $modules->all();

        return [
            'plugin' => [
                'version' => $config->get('version', '0.0.0'),
                'status'  => 'ok',
            ],

            'database' => [
                'version' => $config->get('db_version', '0.0.0'),
                'status'  => 'ok',
            ],

            'modules' => [
                'count'  => count($loadedModules),
                'items'  => array_map(
                    static fn (object $module): string => $module::class,
                    $loadedModules
                ),
                'status' => count($loadedModules) > 0 ? 'ok' : 'warning',
            ],

            'services' => [
                'items'  => $this->coreServicesStatus(),
                'status' => $this->allCoreServicesAvailable() ? 'ok' : 'error',
            ],
        ];
    }

    private function coreServicesStatus(): array
    {
        $services = [];

        foreach (self::CORE_SERVICES as $serviceId) {
            $services[$serviceId] = [
                'available' => $this->serviceAvailable($serviceId),
            ];
        }

        return $services;
    }

    private function allCoreServicesAvailable(): bool
    {
        foreach (self::CORE_SERVICES as $serviceId) {
            if (! $this->serviceAvailable($serviceId)) {
                return false;
            }
        }

        return true;
    }

    private function serviceAvailable(string $serviceId): bool
    {
        try {
            $this->container->get($serviceId);
            return true;
        } catch (Throwable) {
            return false;
        }
    }
}