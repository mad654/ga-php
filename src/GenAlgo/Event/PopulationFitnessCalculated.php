<?php


namespace GenAlgo\Event;


class PopulationFitnessCalculated extends PairSelected
{

    /**
     * @var float
     */
    private $avgPopulationFitness;

    /**
     * @var array;
     */
    private $fitnessDetails;

    /**
     * PopulationFitnessCalculated constructor.
     * @param float $avgPopulationFitness
     * @param $fitnessDetails
     */
    public function __construct($avgPopulationFitness, $fitnessDetails)
    {
        $this->avgPopulationFitness = $avgPopulationFitness;
        $this->fitnessDetails = $fitnessDetails;
    }

    /**
     * @return float
     */
    public function getAvgPopulationFitness()
    {
        return $this->avgPopulationFitness;
    }

    /**
     * @return mixed
     */
    public function getFitnessDetails()
    {
        return $this->fitnessDetails;
    }


}
