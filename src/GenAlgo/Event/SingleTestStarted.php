<?php


namespace GenAlgo\Event;


use Common\ArrayAble;
use Common\ImmutableDataObjectTrait;
use GenAlgo\ComputationData\ComputationEnvironment;
use GenAlgo\ComputationData\ComputationRequest;

class SingleTestStarted implements ArrayAble
{
    use ImmutableDataObjectTrait;

    /**
     * @var ComputationRequest
     */
    public $request;

    /**
     * @var ComputationEnvironment
     */
    public $environment;

    /**
     * SingleTestStarted constructor.
     * @param ComputationRequest $request
     * @param $environment
     */
    public function __construct(ComputationRequest $request, $environment)
    {
        $this->request = $request;
        $this->environment = $environment;
        $this->freeze();
    }
}
