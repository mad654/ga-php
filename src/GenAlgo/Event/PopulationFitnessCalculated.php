<?php


namespace GenAlgo\Event;


use Common\ArrayAble;
use Common\ImmutableDataObjectTrait;

class PopulationFitnessCalculated implements ArrayAble
{
    use ImmutableDataObjectTrait;

    /**
     * @var float
     */
    public $avgPopulationFitness;

    /**
     * @var array;
     */
    public $fitnessDetails;

    /**
     * PopulationFitnessCalculated constructor.
     * @param float $avgPopulationFitness
     * @param $fitnessDetails
     */
    public function __construct($avgPopulationFitness, $fitnessDetails)
    {
        $this->avgPopulationFitness = $avgPopulationFitness;
        $this->fitnessDetails = $fitnessDetails;
        $this->freeze();
    }
}
