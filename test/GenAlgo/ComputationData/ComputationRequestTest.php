<?php

namespace GenAlgo\ComputationData;


use GenAlgo\ConfigurationValues;

class ComputationRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldOneDimensionArray() {
        $request = ComputationRequest::from(
            100,
            1,
            10,
            ConfigurationValues::fromArray([])
        );

        $this->assertEquals([
            'searched' => 100,
            'currentTestNumber' => 1,
            'maxTestNumber' => 10,
            // from ConfigrationValues
            'maxPopulations' => 100,
            'populationSize' => 100,
            'crossoverRate' => 0.7,
            'mutationRate' => 0.001,
            'maxSelectionAttempts' => 10000

        ], $request->toArray());
    }
}
