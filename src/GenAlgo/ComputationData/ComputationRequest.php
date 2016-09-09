<?php


namespace GenAlgo\ComputationData;


use Common\ArrayAble;
use GenAlgo\ConfigurationValues;

class ComputationRequest implements ArrayAble
{
    /**
     * @var misc
     */
    private $searched;

    /**
     * @var int
     */
    private $currentTestNumber;

    /**
     * @var int
     */
    private $maxTestNumber;

    /**
     * @var ConfigurationValues
     */
    private $configuration;

    private function __construct() {}

    /**
     * @param misc $searchedValue
     * @param int $currentTest
     * @param int $maxTests
     * @param ConfigurationValues $c
     * @return ComputationRequest
     */
    public static function from($searchedValue, $currentTest, $maxTests, ConfigurationValues $c)
    {
        $result = new ComputationRequest();
        $result->searched = $searchedValue;
        $result->currentTestNumber = $currentTest;
        $result->maxTestNumber = $maxTests;
        $result->configuration = $c;
        return $result;
    }

    public function toArray() {
        $result = [
            'searched' => $this->searched,
            'currentTestNumber' => $this->currentTestNumber,
            'maxTestNumber' => $this->maxTestNumber,
        ];

        return array_merge($result, $this->configuration->toArray());
    }

    /**
     * @return misc
     */
    public function getSearched()
    {
        return $this->searched;
    }

    /**
     * @return int
     */
    public function getCurrentTestNumber()
    {
        return $this->currentTestNumber;
    }

    /**
     * @return int
     */
    public function getMaxTestNumber()
    {
        return $this->maxTestNumber;
    }

    /**
     * @return ConfigurationValues
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }
}
