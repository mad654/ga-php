<?php

// List of active command instances
// which are subclasses of `\Symfony\Component\Console\Command\Command`

// you can push a logger to your commands constructor
/* @var \Monolog\Logger[] $loggers */

return [
    /**
     * <code>$logger->withName()</code>
     * results in:
     *   [2016-08-28 20:53:52] EXAMPLE_APP.HELLO_WORLD.ERROR: A DEMO ERROR
     * instead of:
     *   [2016-08-28 20:53:52] EXAMPLE_APP.ERROR: A DEMO ERROR
     */
    new \GenAlgo\Console\TutorialCommand(
        $loggers['result']->withName($loggers['result']->getName() . '.TUTORIAL'),
        $loggers['default']->withName($loggers['default']->getName() . '.TUTORIAL')
    )
];
