<?php

namespace GenAlgo;


class ConfigurationValuesTest extends \PHPUnit_Framework_TestCase
{
    private $defaultValueArray = [
        'maxPopulations' => 100,
        'populationSize' => 100,
        'crossoverRate' => 0.7,
        'mutationRate' => 0.001,
        'maxSelectionAttempts' => 10000
    ];

    /**
     * @test
     */
    public function shouldReturnObjectWithDefaultValuesByDefault() {
        $config = new ConfigurationValues();
        $this->assertInstanceOf(ConfigurationValues::class, $config);
        $this->assertEquals($this->defaultValueArray, $config->toArray());
    }

    /**
     * @test
     */
    public function shouldOverwriteDefaultsWithGivenValues() {
        $config = new ConfigurationValues($maxPopulations = 10);
        $expectedConfig = $this->defaultValueArray;
        $expectedConfig['maxPopulations'] = 10;
        $this->assertEquals($expectedConfig, $config->toArray());
    }
}
