<?php

declare(strict_types=1);

namespace CDGStudio\Providers;

use CDGStudio\Support\Cache;
use CDGStudio\Contracts\ServiceProviderInterface;
use CDGStudio\Core\Application;
use CDGStudio\Core\ConfigManager;
use CDGStudio\Core\ModuleLoader;
use CDGStudio\Support\Container;
use CDGStudio\Support\EventDispatcher;
use CDGStudio\Support\Logger;
use CDGStudio\Support\HookManager;

final class CoreServiceProvider implements ServiceProviderInterface
{
    public function __construct(
        private Application $app,
        private ModuleLoader $modules
    ) {
    }

    public function register(Container $container): void
    {
        $container->set('cache', fn () => new Cache());
        $container->set('hooks', fn () => new HookManager());
        $container->set('app', fn () => $this->app);

        $container->set('modules', fn () => $this->modules);

        $container->set('config', fn () => new ConfigManager([
            'plugin_file' => defined('CDG_STUDIO_FILE') ? CDG_STUDIO_FILE : '',
            'plugin_path' => defined('CDG_STUDIO_PATH') ? CDG_STUDIO_PATH : '',
            'plugin_url'  => defined('CDG_STUDIO_URL') ? CDG_STUDIO_URL : '',
            'version'     => defined('CDG_STUDIO_VERSION') ? CDG_STUDIO_VERSION : '0.0.0',
            'db_version'  => defined('CDG_STUDIO_DB_VERSION') ? CDG_STUDIO_DB_VERSION : '0.0.0',
        ]));

        $container->set('events', fn () => new EventDispatcher());

        $container->set('logger', fn () => new Logger());
    }
}