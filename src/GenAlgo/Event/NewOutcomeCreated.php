<?php


namespace GenAlgo\Event;


use Common\AbstractDataObject;

// TODO:mad654 use ReadonlyDataObjectTrait

class NewOutcomeCreated extends AbstractDataObject
{
    /**
     * @var mixed
     */
    protected $outcome;

    /**
     * NewOutcomeCreated constructor.
     * @param $newSpez1
     */
    public function __construct($outcome)
    {
        $this->outcome = $outcome;
    }

    /**
     * @return mixed
     */
    public function getOutcome()
    {
        return $this->outcome;
    }

}
