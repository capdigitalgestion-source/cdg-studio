<?php

declare(strict_types=1);

namespace CDGStudio\Core;

use CDGStudio\Support\Container;

final class Application
{
    public const VERSION = '1.0.0';

    private Container $container;

    private ModuleLoader $modules;

    public function __construct()
    {
        $this->container = new Container();
        $this->modules = new ModuleLoader();
    }

    public function boot(): void
    {
        $this->registerCoreServices();

        $this->modules->register();
        $this->modules->boot();
    }

    public function container(): Container
    {
        return $this->container;
    }

    public function modules(): ModuleLoader
    {
        return $this->modules;
    }

    public function config(): ConfigManager
    {
        /** @var ConfigManager $config */
        $config = $this->container->get('config');

        return $config;
    }

    public function version(): string
    {
        return $this->config()->get('version', self::VERSION);
    }

    private function registerCoreServices(): void
    {
        $this->container->set('app', fn () => $this);

        $this->container->set('modules', fn () => $this->modules);

        $this->container->set('config', fn () => new ConfigManager([
            'plugin_file' => defined('CDG_STUDIO_FILE') ? CDG_STUDIO_FILE : '',
            'plugin_path' => defined('CDG_STUDIO_PATH') ? CDG_STUDIO_PATH : '',
            'plugin_url'  => defined('CDG_STUDIO_URL') ? CDG_STUDIO_URL : '',
            'version'     => defined('CDG_STUDIO_VERSION') ? CDG_STUDIO_VERSION : self::VERSION,
        ]));
    }
}