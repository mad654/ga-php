<?php
/**
 * Created by PhpStorm.
 * User: mann
 * Date: 11.09.16
 * Time: 11:07
 */
namespace GenAlgo;

use GenAlgo\AlgorithmTestRunner\EventListenerInterface;
use GenAlgo\ComputationData\ComputationRequest;
use GenAlgo\ComputationData\ComputationResult;

interface AlgorithmInterface
{
    /**
     * @param ComputationRequest $request
     * @return ComputationResult
     */
    public function findSolution(ComputationRequest $request);

    /**
     * @param EventListenerInterface $listener
     */
    public function addEventListener(EventListenerInterface $listener);

    /**
     * @param EventListenerInterface $listener
     */
    public function removeEventListener(EventListenerInterface $listener);
}
