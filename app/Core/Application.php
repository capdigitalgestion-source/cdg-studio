<?php

declare(strict_types=1);

namespace CDGStudio\Core;

use CDGStudio\Support\Container;
use CDGStudio\Modules\Dashboard\DashboardModule;

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

    private function registerCoreServices(): void
    {
        $this->container->set('app', fn () => $this);
        $this->container->set('modules', fn () => $this->modules);
    }

    public function version(): string
    {
        return self::VERSION;
    }
}