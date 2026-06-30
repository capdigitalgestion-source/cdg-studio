<?php

declare(strict_types=1);

namespace CDGStudio\Support;

use CDGStudio\Contracts\LoggerInterface;

final class Logger implements LoggerInterface
{
    public function info(string $message, array $context = []): void
    {
        $this->write('INFO', $message, $context);
    }

    public function warning(string $message, array $context = []): void
    {
        $this->write('WARNING', $message, $context);
    }

    public function error(string $message, array $context = []): void
    {
        $this->write('ERROR', $message, $context);
    }

    private function write(string $level, string $message, array $context): void
    {
        if (!defined('WP_DEBUG_LOG') || WP_DEBUG_LOG !== true) {
            return;
        }

        $line = sprintf(
            '[CDG Studio] [%s] %s',
            $level,
            $message
        );

        if ($context !== []) {
            $line .= ' ' . wp_json_encode($context);
        }

        error_log($line);
    }
}