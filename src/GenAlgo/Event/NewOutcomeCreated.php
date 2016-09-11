<?php


namespace GenAlgo\Event;


use Common\AbstractDataObject;

class NewOutcomeCreated extends AbstractDataObject
{
    /**
     * @var mixed
     */
    private $outcome;

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
