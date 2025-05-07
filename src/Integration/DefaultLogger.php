<?php

namespace CF\Integration;

use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;
use Stringable;

class DefaultLogger extends AbstractLogger
{
    private bool $debug;

    public const PREFIX = '[Cloudflare]';

    public function __construct(bool $debug = false)
    {
        $this->debug = $debug;
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param \Psr\Log\LogLevel::* $level
     * @param Stringable|string $message
     * @param array $context
     */
    public function log($level, Stringable|string $message, array $context = []): void
    {
        error_log(self::PREFIX . ' ' . strtoupper((string) $level) . ': ' . (string) $message . ' ' .
            (!empty($context) ? print_r($context, true) : ''));
    }

    /**
     * Logs debug messages only if debug is enabled.
     *
     * @param Stringable|string $message
     * @param array $context
     */
    public function debug(Stringable|string $message, array $context = []): void
    {
        if ($this->debug) {
            $this->log(LogLevel::DEBUG, $message, $context);
        }
    }
}
