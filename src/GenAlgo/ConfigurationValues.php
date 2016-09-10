<?php


namespace GenAlgo;


use Common\AbstractDataObject;


class ConfigurationValues extends AbstractDataObject
{
    protected $maxPopulations = 100;
    protected $populationSize = 100;

    protected $crossoverRate = 0.7;
    protected $mutationRate = 0.001;
    protected $maxSelectionAttempts = 10000;

    protected function __construct() {

    }

    /**
     * @return int
     */
    public function MaxPopulations()
    {
        return $this->maxPopulations;
    }

    /**
     * @return int
     */
    public function PopulationSize()
    {
        return $this->populationSize;
    }

    /**
     * @return float
     */
    public function CrossoverRate()
    {
        return $this->crossoverRate;
    }

    /**
     * @return float
     */
    public function MutationRate()
    {
        return $this->mutationRate;
    }

    /**
     * @return int
     */
    public function MaxSelectionAttempts()
    {
        return $this->maxSelectionAttempts;
    }

}
