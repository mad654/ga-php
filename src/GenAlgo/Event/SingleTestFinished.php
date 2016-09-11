<?php


namespace GenAlgo\Event;


use GenAlgo\ComputationData\ComputationEnvironment;
use GenAlgo\ComputationData\ComputationResult;

class SingleTestFinished
{
    /**
     * @var ComputationResult
     */
    private $result;

    /**
     * @var ComputationEnvironment
     */
    private $environment;

    /**
     * SingleTestFinished constructor.
     * @param ComputationResult $result
     * @param ComputationEnvironment $environment
     */
    public function __construct(ComputationResult $result, ComputationEnvironment $environment)
    {
        $this->result = $result;
        $this->environment = $environment;
    }

    /**
     * @return ComputationResult
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @return ComputationEnvironment
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

}
