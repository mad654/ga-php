<?php


namespace GenAlgo;


use GenAlgo\AlgorithmTestRunner\EventListenerInterface;
use GenAlgo\ComputationData\ComputationEnvironment;
use GenAlgo\ComputationData\ComputationRequest;
use GenAlgo\ComputationData\ComputationResult;

class AlgorithmTestRunner
{
    /**
     * @var AlgorithmInterface
     */
    private $algorithm;

    /**
     * @var ConfigurationValues
     */
    private $evolutionConfig;

    /**
     * @var ComputationEnvironment
     */
    private $environment;

    /**
     * @var EventListenerInterface || \SplObjectStorage
     */
    private $eventListener;

    /**
     * AlgorithmTestRunner constructor.
     * @param AlgorithmInterface $algorithm
     * @param ConfigurationValues $evolutionConfig
     * @param ComputationEnvironment $environment
     */
    public function __construct(
        AlgorithmInterface $algorithm,
        ComputationEnvironment $environment,
        ConfigurationValues $evolutionConfig
    ) {
        $this->algorithm = $algorithm;
        $this->evolutionConfig = $evolutionConfig;
        $this->environment = $environment;
        $this->eventListener = new \SplObjectStorage();
    }


    /**
     * @param $target
     * @param int $testCount
     */
    public function run($target, $testCount)
    {
        $this->notifyRunStarted();

        for ($i = 1; $i <= $testCount; $i++) {
            $request = ComputationRequest::from($target, $i, $testCount, $this->evolutionConfig);

            $this->notifySingleTestStarted($request);
            $result = $this->algorithm->findSolution($request);
            $this->notifySingleTestFinished($result);
        }

        $this->notifyRunFinished();
    }

    /**
     * @param EventListenerInterface $listener
     */
    public function addEventListener(EventListenerInterface $listener) {
        $this->eventListener->attach($listener);
        $this->algorithm->addEventListener($listener);
    }

    /**
     * @param EventListenerInterface $listener
     */
    public function removeEventListener(EventListenerInterface $listener) {
        $this->algorithm->removeEventListener($listener);
        $this->eventListener->detach($listener);
    }

    private function notifyRunStarted()
    {
        $this->notify(new Event\RunStartedEvent($this->environment), 'handleRunStarted');
    }

    private function notifySingleTestStarted(ComputationRequest $request)
    {
        $this->notify(new Event\SingleTestStarted($request, $this->environment), 'handleSingleTestStarted');
    }

    private function notifySingleTestFinished(ComputationResult $result)
    {
        $this->notify(new Event\SingleTestFinished($result, $this->environment), 'handleSingleTestFinished');
    }

    private function notifyRunFinished()
    {
        $this->notify(new Event\RunFinishedEvent($this->environment), 'handleRunFinished');
    }

    private function notify($event, $listenerFunction)
    {
        foreach ($this->eventListener as $listener) {
            $listener->$listenerFunction($event);
        }
    }
}
