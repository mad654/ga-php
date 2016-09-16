<?php


namespace GenAlgo\Event;


use Common\ArrayAble;
use Common\ImmutableDataObjectTrait;

// TODO:mad654 use ReadonlyDataObjectTrait

class NewOutcomeCreated implements ArrayAble
{
    use ImmutableDataObjectTrait;

    public $outcome;

    /**
     * NewOutcomeCreated constructor.
     * @param $newSpez1
     */
    public function __construct($outcome)
    {
        $this->outcome = $outcome;
        $this->freeze();
    }
}
