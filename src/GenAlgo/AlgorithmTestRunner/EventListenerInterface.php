<?php


namespace GenAlgo\AlgorithmTestRunner;


use GenAlgo\Event\RunFinishedEvent;
use GenAlgo\Event\RunStartedEvent;
use GenAlgo\Event\SingleTestFinished;
use GenAlgo\Event\SingleTestStarted;

interface EventListenerInterface
{
    /**
     * @param RunStartedEvent $e
     */
    public function handleRunStarted(RunStartedEvent $e);

    /**
     * @param SingleTestStarted $e
     */
    public function handleSingleTestStarted(SingleTestStarted $e);

    /**
     * @param SingleTestFinished $e
     */
    public function handleSingleTestFinished(SingleTestFinished $e);

    /**
     * @param RunFinishedEvent $e
     */
    public function handleRunFinished(RunFinishedEvent $e);
}
