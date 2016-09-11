<?php


namespace GenAlgo\Event;


use GenAlgo\ComputationData\ComputationEnvironment;

class RunFinishedEvent
{

    private $environment;

    /**
     * RunFinishedEvent constructor.
     * @param ComputationEnvironment $environment
     */
    public function __construct(ComputationEnvironment $environment)
    {
        $this->environment;
    }

    /**
     * @return mixed
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

}
