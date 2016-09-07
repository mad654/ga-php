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
        $config = ConfigurationValues::fromArray([]);
        $this->assertInstanceOf(ConfigurationValues::class, $config);
        $this->assertEquals($this->defaultValueArray, $config->toArray());
    }

    /**
     * @test
     */
    public function shouldOverwriteDefaultsWithGivenValues() {
        $config = ConfigurationValues::fromArray(['maxPopulations' => 10]);
        $expectedConfig = $this->defaultValueArray;
        $expectedConfig['maxPopulations'] = 10;
        $this->assertEquals($expectedConfig, $config->toArray());
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Undefined property: notExistingConfig
     */
    public function shouldThrowExceptionIfConfigurationPropertyIsNotDefined() {
        $config = ConfigurationValues::fromArray(['notExistingConfig' => 10]);
    }
}
