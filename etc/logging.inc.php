<?php

# init monolog handlers
# @see https://github.com/Seldaek/monolog
# @see https://github.com/Seldaek/monolog/blob/master/doc/01-usage.md#log-levels

/* @var \Monolog\Logger $logger */
use Monolog\Processor\MemoryPeakUsageProcessor;
use Monolog\Processor\MemoryUsageProcessor;
use Monolog\Processor\ProcessIdProcessor;
use Monolog\Processor\PsrLogMessageProcessor;

/* @var string $logDir */
/* @var string $logFileName */

$logger->useMicrosecondTimestamps(true);

// Development + Production
$resultLogger = $logger->withName($logger->getName() . '.RESULTS');
$resultLogger->pushHandler(
    (new \Monolog\Handler\StreamHandler(
        "$logDir/$logFileName.result.json",
        \Monolog\Logger::INFO,
        $bubble = false
    ))->setFormatter(new \Monolog\Formatter\JsonFormatter())
);

$logger->pushHandler(new \Monolog\Handler\FingersCrossedHandler(
    new \Monolog\Handler\StreamHandler(
        "$logDir/$logFileName.error.log",
        \Monolog\Logger::DEBUG,
        $bubble = true
    ),
    null,
    getenv('APP_LOG_BUFFER')
));

// Development
$logger->pushHandler(
    (
    new \Monolog\Handler\StreamHandler(
        "$logDir/$logFileName.debug.json",
        \Monolog\Logger::DEBUG,
        $bubble = true
    )
    )->setFormatter(new \Monolog\Formatter\JsonFormatter())
);

$logger->pushProcessor(new PsrLogMessageProcessor());
$logger->pushProcessor(new ProcessIdProcessor());
$logger->pushProcessor(new MemoryUsageProcessor());
$logger->pushProcessor(new MemoryPeakUsageProcessor());

return [
    'default' => $logger,
    'result' => $resultLogger
];
