<?php

declare(strict_types=1);

namespace CDGStudio\Core;

use CDGStudio\Providers\CoreServiceProvider;
use CDGStudio\Support\Container;

final class Application
{
    private Container $container;

    private ModuleLoader $modules;

    public function __construct()
    {
        $this->container = new Container();
        $this->modules = new ModuleLoader();
    }

    public function boot(): void
    {
        $this->registerProviders();

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
        return $this->config()->get('version', '0.0.0');
    }

    private function registerProviders(): void
    {
        $providers = [
            new CoreServiceProvider($this, $this->modules),
        ];

        foreach ($providers as $provider) {
            $provider->register($this->container);
        }
    }
}