<?php


namespace GenAlgo;


use Common\ArrayAble;
use Common\ImmutableDataObjectTrait;


class ConfigurationValues implements ArrayAble
{
    use ImmutableDataObjectTrait;

    public $maxPopulations;
    public $populationSize;

    public $crossoverRate;
    public $mutationRate;
    public $maxSelectionAttempts;

    /**
     * ConfigurationValues constructor.
     *
     * @param int $maxPopulations
     * @param int $populationSize
     * @param float $crossoverRate
     * @param float $mutationRate
     * @param int $maxSelectionAttempts
     */
    public function __construct(
        $maxPopulations = 100,
        $populationSize = 100,
        $crossoverRate = 0.7,
        $mutationRate = 0.001,
        $maxSelectionAttempts = 10000
    ) {
        $this->maxPopulations = $maxPopulations;
        $this->populationSize = $populationSize;
        $this->crossoverRate = $crossoverRate;
        $this->mutationRate = $mutationRate;
        $this->maxSelectionAttempts = $maxSelectionAttempts;

        $this->freeze();
    }


}
