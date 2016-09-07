<?php


namespace GenAlgo;


class ConfigurationValues
{
    private $maxPopulations = 100;
    private $populationSize = 100;

    private $crossoverRate = 0.7;
    private $mutationRate = 0.001;
    private $maxSelectionAttempts = 10000;

    private function __construct() {

    }

    /**
     * @param array $configData
     * @return ConfigurationValues
     */
    public static function fromArray($configData)
    {
        $result = new ConfigurationValues();

        foreach ($configData as $key => $value) {
            if (!property_exists($result, $key)) {
                throw new \InvalidArgumentException("Undefined property: $key");
            }

            $result->$key = $value;
        }

        return $result;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $result = [];

        foreach ($this as $key => $value) {
            $result[$key] = $value;
        }

        return $result;
    }

    /**
     * @return int
     */
    public function getMaxPopulations()
    {
        return $this->maxPopulations;
    }

    /**
     * @return int
     */
    public function getPopulationSize()
    {
        return $this->populationSize;
    }

    /**
     * @return float
     */
    public function getCrossoverRate()
    {
        return $this->crossoverRate;
    }

    /**
     * @return float
     */
    public function getMutationRate()
    {
        return $this->mutationRate;
    }

    /**
     * @return int
     */
    public function getMaxSelectionAttempts()
    {
        return $this->maxSelectionAttempts;
    }

}
