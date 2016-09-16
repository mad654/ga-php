<?php


namespace GenAlgo\Event;


use Common\ArrayAble;
use Common\ImmutableDataObjectTrait;
use GenAlgo\ComputationData\ComputationEnvironment;

class RunStartedEvent implements ArrayAble
{
    use ImmutableDataObjectTrait;

    /**
     * @var ComputationEnvironment
     */
    public $environment;

    /**
     * RunStartedEvent constructor.
     * @param ComputationEnvironment $environment
     */
    public function __construct(ComputationEnvironment $environment)
    {
        $this->environment = $environment;
        $this->freeze();
    }
}
