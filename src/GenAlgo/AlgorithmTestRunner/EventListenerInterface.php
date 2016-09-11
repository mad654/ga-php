<?php


namespace GenAlgo\AlgorithmTestRunner;


use GenAlgo\Event\NewOutcomeCreated;
use GenAlgo\Event\PairSelected;
use GenAlgo\Event\PopulationCreated;
use GenAlgo\Event\PopulationFitnessCalculated;
use GenAlgo\Event\RunFinishedEvent;
use GenAlgo\Event\RunStartedEvent;
use GenAlgo\Event\SingleTestFinished;
use GenAlgo\Event\SingleTestStarted;
use GenAlgo\Event\SpezSelected;

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

    // Algorithm listeners

    public function handleSpezSelected(SpezSelected $e);

    public function handleNewOutcomeCreated(NewOutcomeCreated $e);

    public function handlePairSelected(PairSelected $e);

    public function handlePopulationFitnessCalculated(PopulationFitnessCalculated $e);

    public function handlePopulationCreated(PopulationCreated $e);
}
