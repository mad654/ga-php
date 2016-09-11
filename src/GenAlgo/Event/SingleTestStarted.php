<?php


namespace GenAlgo\Event;


use GenAlgo\ComputationData\ComputationEnvironment;
use GenAlgo\ComputationData\ComputationRequest;

class SingleTestStarted
{

    /**
     * @var ComputationRequest
     */
    private $request;

    /**
     * @var ComputationEnvironment
     */
    private $environment;

    /**
     * SingleTestStarted constructor.
     * @param ComputationRequest $request
     * @param $environment
     */
    public function __construct(ComputationRequest $request, $environment)
    {
        $this->request = $request;
        $this->environment = $environment;
    }

    /**
     * @return ComputationRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return mixed
     */
    public function getEnvironment()
    {
        return $this->environment;
    }
}
