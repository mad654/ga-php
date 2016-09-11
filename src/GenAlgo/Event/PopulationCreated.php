<?php


namespace GenAlgo\Event;


use Common\AbstractDataObject;

class PopulationCreated extends AbstractDataObject
{
    /**
     * @var int
     */
    protected $generation;

    /**
     * @var array
     */
    protected $population;

    /**
     * PopulationCreated constructor.
     * @param int $generation
     * @param array $population
     */
    public function __construct($generation, $population)
    {
        $this->generation = $generation;
        $this->population = $population;
    }

    /**
     * @return int
     */
    public function getGeneration()
    {
        return $this->generation;
    }

    /**
     * @return array
     */
    public function getPopulation()
    {
        return $this->population;
    }


}
