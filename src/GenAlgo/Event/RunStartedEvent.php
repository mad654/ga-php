<?php


namespace GenAlgo\Event;


use GenAlgo\ComputationData\ComputationEnvironment;

class RunStartedEvent
{
    private $environment;

    /**
     * RunStartedEvent constructor.
     * @param ComputationEnvironment $environment
     */
    public function __construct(ComputationEnvironment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * @return ComputationEnvironment
     */
    public function getEnvironment()
    {
        return $this->environment;
    }
}
