<?php

declare(strict_types=1);

namespace CDGStudio\Contracts;

use CDGStudio\Support\Container;

interface ServiceProviderInterface
{
    public function register(Container $container): void;
}