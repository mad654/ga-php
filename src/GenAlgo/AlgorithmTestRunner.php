<?php


namespace GenAlgo;


use GenAlgo\ComputationData\ComputationEnvironment;
use GenAlgo\ComputationData\ComputationRequest;

class AlgorithmTestRunner
{
    /**
     * @var AlgorithmInterface
     */
    private $algorithm;

    /**
     * @var ConfigurationValues
     */
    private $evolutionConfig;

    /**
     * @var ComputationEnvironment
     */
    private $environment;

    /**
     * AlgorithmTestRunner constructor.
     * @param AlgorithmInterface $algorithm
     * @param ConfigurationValues $evolutionConfig
     * @param ComputationEnvironment $environment
     */
    public function __construct(
        AlgorithmInterface $algorithm,
        ComputationEnvironment $environment,
        ConfigurationValues $evolutionConfig
    ) {
        $this->algorithm = $algorithm;
        $this->evolutionConfig = $evolutionConfig;
        $this->environment = $environment;
    }


    /**
     * @param $target
     * @param int $testCount
     */
    public function run($target, $testCount)
    {
        for ($i = 1; $i <= $testCount; $i++) {
            $r = ComputationRequest::from($target, $i, $testCount, $this->evolutionConfig);
            $result = $this->algorithm->findSolution($r);

            $output = array_merge($this->environment->toArray(), $result->toArray());
            echo implode(' ', $output) . PHP_EOL;
        }
    }
}
