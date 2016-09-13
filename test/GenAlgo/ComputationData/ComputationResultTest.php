<?php

namespace GenAlgo\ComputationData;


use GenAlgo\ConfigurationValues;

class ComputationResultTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldReturnOnDimensionArray() {
        /**
         * ComputationResult
         * - started [\DateTime]
         * - stopped [\DateTime]
         * - result_type ['OK', 'SELECTION_TIMEOUT', 'POPULATION_TIMEOUT']
         * - result
         * - result_data
         * - runtime
         * - last_population_number
         */
        $result = $this->createSut();
        $result->start();
        $result->foundResult('result',['result' => 'extra-data'],15);
        $actual = $result->toArray();

        $this->assertEquals($actual['started'], date(DATE_ATOM));
        $this->assertEquals($actual['stopped'], date(DATE_ATOM));
        $this->assertEquals($actual['resultType'], ComputationResult::RESULT_TYPE_OK);
        $this->assertEquals($actual['result'], 'result');
        $this->assertEquals($actual['resultData'], json_encode(['result' => 'extra-data']));
        $this->assertEquals($actual['lastPopulationNumber'], 15);
        $this->assertGreaterThan(0, $actual['runtime']);

        // from request
        $this->assertEquals($actual['searched'], 1);
        $this->assertEquals($actual['currentTestNumber'], 1);
        $this->assertEquals($actual['maxPopulations'], 100);
        $this->assertEquals($actual['populationSize'], 100);
        $this->assertEquals($actual['crossoverRate'], 0.7);
        $this->assertEquals($actual['mutationRate'], 0.001);
        $this->assertEquals($actual['maxSelectionAttempts'], 10000);
    }

    /**
     * @test
     * @expectedException \DomainException
     * @expectedExceptionMessage Already started, update results or create new instance
     */
    public function shouldThrowExceptionIfAlreadyStarted() {
        $result = $this->createSut();
        $result->start();
        $result->start();
    }

    /**
     * @test
     * @expectedException \DomainException
     * @expectedExceptionMessage Call start first
     */
    public function shouldThrowExceptionIfNotYetStartedFoundResult() {
        $result = $this->createSut();
        $result->foundResult(1, [], 1);
    }

    /**
     * @test
     * @expectedException \DomainException
     * @expectedExceptionMessage Call start first
     */
    public function shouldThrowExceptionIfNotYetStartedSelectionTimeout() {
        $result = $this->createSut();
        $result->selectionTimedOut([], 1);
    }

    /**
     * @test
     * @expectedException \DomainException
     * @expectedExceptionMessage Call start first
     */
    public function shouldThrowExceptionIfNotYetStartedPopulationTimeout() {
        $result = $this->createSut();
        $result->populationTimedOut([], 1);
    }

    /**
     * @test
     * @expectedException \DomainException
     * @expectedExceptionMessage Already stopped, create new instance
     */
    public function shouldThrowExceptionIfAlreadyStoppedFoundResult() {
        $result = $this->createSut();
        $result->start();
        $result->foundResult(1, [], 1);
        $result->foundResult(1, [], 1);
    }

    /**
     * @test
     * @expectedException \DomainException
     * @expectedExceptionMessage Already stopped, create new instance
     */
    public function shouldThrowExceptionIfAlreadyStoppedSelectionTimedOut() {
        $result = $this->createSut();
        $result->start();
        $result->selectionTimedOut([], 1);
        $result->selectionTimedOut([], 1);
    }

    /**
     * @test
     * @expectedException \DomainException
     * @expectedExceptionMessage Already stopped, create new instance
     */
    public function shouldThrowExceptionIfAlreadyStoppedSPopulationTimedOut() {
        $result = $this->createSut();
        $result->start();
        $result->populationTimedOut([], 1);
        $result->populationTimedOut([], 1);
    }

    /**
     * @return ComputationResult
     */
    private function createSut()
    {
        $request = ComputationRequest::from(1, 1, 1, new ConfigurationValues());
        $result = new ComputationResult($request);

        return $result;
    }
}
