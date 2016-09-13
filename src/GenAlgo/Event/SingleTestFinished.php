<?php


namespace GenAlgo\Event;


use Common\ArrayAble;
use Common\ImmutableDataObjectTrait;
use GenAlgo\ComputationData\ComputationEnvironment;
use GenAlgo\ComputationData\ComputationResult;

class SingleTestFinished implements ArrayAble
{
    use ImmutableDataObjectTrait;

    /**
     * @var ComputationResult
     */
    public $result;

    /**
     * @var ComputationEnvironment
     */
    public $environment;

    /**
     * SingleTestFinished constructor.
     * @param ComputationResult $result
     * @param ComputationEnvironment $environment
     */
    public function __construct(ComputationResult $result, ComputationEnvironment $environment)
    {
        $this->result = $result;
        $this->environment = $environment;
        $this->freeze();
    }
}
