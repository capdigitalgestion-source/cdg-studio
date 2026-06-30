<?php

declare(strict_types=1);

namespace CDGStudio\Core;

use CDGStudio\Contracts\ModuleInterface;
use CDGStudio\Support\Cache;
use CDGStudio\Support\Container;
use CDGStudio\Support\EventDispatcher;
use CDGStudio\Support\HookManager;
use Psr\Log\LoggerInterface;

abstract class AbstractModule implements ModuleInterface
{
    public function __construct(
        protected Container $container
    ) {
    }

    protected function config(): ConfigManager
    {
        return $this->container->get('config');
    }

    protected function logger(): LoggerInterface
    {
        return $this->container->get('logger');
    }

    protected function events(): EventDispatcher
    {
        return $this->container->get('events');
    }

    protected function hooks(): HookManager
    {
        return $this->container->get('hooks');
    }

    protected function cache(): Cache
    {
        return $this->container->get('cache');
    }

    protected function settings(): SettingsManager
    {
        return $this->container->get('settings');
    }
}