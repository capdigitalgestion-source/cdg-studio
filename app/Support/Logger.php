<?php

declare(strict_types=1);

namespace CDGStudio\Support;

use Psr\Log\AbstractLogger;

final class Logger extends AbstractLogger
{
    public function log($level, string|\Stringable $message, array $context = []): void
    {
        if (!defined('WP_DEBUG_LOG') || WP_DEBUG_LOG !== true) {
            return;
        }

        $line = sprintf(
            '[CDG Studio] [%s] %s',
            strtoupper((string) $level),
            (string) $message
        );

        if ($context !== []) {
            $line .= ' ' . wp_json_encode($context);
        }

        error_log($line);
    }
}