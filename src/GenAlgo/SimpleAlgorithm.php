<?php

namespace GenAlgo;

use GenAlgo\AlgorithmTestRunner\EventListenerInterface;
use GenAlgo\ComputationData\ComputationRequest;
use GenAlgo\ComputationData\ComputationResult;

use GenAlgo\SimpleAlgorithm\SolutionException;
use GenAlgo\SimpleAlgorithm\SimpleCode;
use GenAlgo\ConfigurationValues;
use GenAlgo\SelectionException;

use GenAlgo\Event\NewOutcomeCreated;
use GenAlgo\Event\PairSelected;
use GenAlgo\Event\PopulationCreated;
use GenAlgo\Event\PopulationFitnessCalculated;
use GenAlgo\Event\SpezSelected;
use RuntimeException;


// todo:mann test 24k with 0.09609375 AND 0.09375 each in one process
class SimpleAlgorithm implements AlgorithmInterface
{
    const CODE = [
        '0000' => '0',
        '0001' => '1',
        '0010' => '2',
        '0011' => '3',
        '0100' => '4',
        '0101' => '5',
        '0110' => '6',
        '0111' => '7',
        '1000' => '8',
        '1001' => '9',
        '1010' => '+',
        '1011' => '-',
        '1100' => '*',
        '1101' => '/',
    ];
    const CHROMOSOME_LENGTH = 9;

    private $eventListener;

    public function __construct()
    {
        $this->eventListener = new \SplObjectStorage();
    }

    /**
     * @param EventListenerInterface $listener
     */
    public function addEventListener(EventListenerInterface $listener)
    {
        $this->eventListener->attach($listener);
    }

    /**
     * @param EventListenerInterface $listener
     */
    public function removeEventListener(EventListenerInterface $listener)
    {
        $this->eventListener->detach($listener);
    }

    /**
     * @param $event
     * @param $listenerFunction
     */
    private function notify($event, $listenerFunction) {
        foreach ($this->eventListener as $listener) {
            $listener->$listenerFunction($event);
        }
    }

# interesting MUTATION_RATES
#const MUTATION_RATE     = 0.09375;
#const MUTATION_RATE     = 0.09609375;


    /**
     * @param ComputationRequest $request
     * @return ComputationResult
     */
    public function findSolution(ComputationRequest $request)
    {
        $result = new ComputationResult($request);
        $result->start();
        $searchedValue = $request->getSearched();
        $c = $request->getConfiguration();

        // todo: mann: store intial population of long running
        // todo: mann: test optimal parameters
        // todo: mann: are optimal parameters generic or problem related?
        $code = new SimpleCode(self::CODE);
        $population = $this->initPopulation($code, $c->populationSize, self::CHROMOSOME_LENGTH);
        $this->notify(new PopulationCreated(1, $population), 'handlePopulationCreated');

        $counter = 1;

        while (true) {
            try {
                $new = $this->generateNewPopulation($population, $code, $c, $searchedValue);
            } catch (SolutionException $e) {
                return $result->foundResult($e->getMessage(), [], $counter);
            } catch (SelectionException $e) {
                return $result->selectionTimedOut($population, $counter, $e->getErrorPopulation());
            }

            $counter++;
            $population = $new;

            if ($counter >= $c->maxPopulations) {
                return $result->populationTimedOut($population, $counter);
            }

            $this->notify(new PopulationCreated($counter, $population), 'handlePopulationCreated');
        }
    }

    /**
     * @param SimpleCode $code
     * @param $size
     * @param $length
     * @return array
     */
    private function initPopulation(SimpleCode $code, $size, $length)
    {
        $population = [];

        for ($i = 0; $i < $size; $i++) {
            $population[] = $this->generateNewSpez($code, $length);
        }

        return $population;
    }

    /**
     * @param SimpleCode $code
     * @param $length
     * @return string
     */
    private function generateNewSpez(SimpleCode $code, $length)
    {
        $newSpez = '';

        for ($i = 0; $i < $length; $i++) {
            $newSpez .= $code->randomGen();
        }

        return $newSpez;
    }

    /**
     * @param array $population
     * @param SimpleCode $code
     * @param ConfigurationValues $c
     * @param $searched
     * @return array
     */
    private function generateNewPopulation(
        array $population,
        SimpleCode $code,
        ConfigurationValues $c,
        $searched
    ) {
        $newPopulation = [];
        $fitness = $this->testPoputlation($population, $code, $searched);
        $populationFitness = $this->calcFitnessSum($fitness) / count($population);
        $this->notify(
            new PopulationFitnessCalculated($populationFitness, $population),
            'handlePopulationFitnessCalculated'
        );

        while (count($population) > count($newPopulation)) {
            list($spez1, $spez2) = $this->selectPair($fitness, $c);
            $this->notify(new PairSelected($spez1, $spez2), 'handlePairSelected');

            list($newSpez1, $newSpez2) = $this->sex($spez1['chromosome'], $spez2['chromosome'], $c);

            if (!empty($newSpez1)) {
                $this->notify(new NewOutcomeCreated($newSpez1), 'handleNewOutcomeCreated');
                $newPopulation[] = $newSpez1;
            }

            if (!empty($newSpez2)) {
                $this->notify(new NewOutcomeCreated($newSpez1), 'handleNewOutcomeCreated');
                $newPopulation[] = $newSpez2;
            }
        }

        return $newPopulation;
    }

    /**
     * @param array $population
     * @param SimpleCode $code
     * @param $searched
     * @return array
     */
    private function testPoputlation(array $population, SimpleCode $code, $searched)
    {
        $fitnessAbsolute = [];

        foreach ($population as $spez) {
            $decoded = $code->decode($spez);
            $fitness = $this->calculateFittness($searched, $decoded);

            $fitnessAbsolute[] = [
                'chromosome' => $spez,
                'fitnessAbsolute' => $fitness
            ];
        }

        $fitnessRelative = $this->calcRelativeFitness($fitnessAbsolute);
        usort($fitnessRelative, function ($a, $b) {
            // usort casts result to integer, so we have to return a big
            // integer which is big enough to meet our precision requirements
            // @see http://us2.php.net/manual/en/function.usort.php
            return
                $a['fitnessRelative'] * 1000000000000000 -
                $b['fitnessRelative'] * 1000000000000000;
        });

        return $fitnessRelative;
    }

    /**
     * @param $searched
     * @param $decoded
     * @return float
     * @throws SolutionException
     */
    private function calculateFittness($searched, $decoded)
    {
        $valid = $this->cleanUp($decoded);
        # echo "$valid ";

        $result = eval("return $valid;");
        # echo "= $result >> ";

        $difference = $searched - $result;
        if ($difference == 0) {
            throw new SolutionException($valid);
        }

        return 1 / ($difference);
    }

    /**
     * @param $code
     * @return mixed|string
     */
    private function cleanUp($code)
    {
        $numbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $signs = ['+', '-', '*', '/'];
        $needsSign = false;
        $result = [];

        foreach (str_split($code) as $diggest) {
            if ($needsSign === false && in_array($diggest, $numbers)) {
                $result[] = $diggest;
                $needsSign = true;
            }

            if ($needsSign && in_array($diggest, $signs)) {
                $result[] = $diggest;
                $needsSign = false;
            }
        }

        // make sure last diggest is a number
        $last = array_pop($result);
        if (in_array($last, $numbers)) {
            $result[] = $last;
        }

        // avoid division by zero errors
        $returnValue = implode('', $result);
        $returnValue = str_replace('/0', '', $returnValue);

        if (empty($returnValue)) {
            return '0';
        }

        return $returnValue;
    }

    /**
     * @param array $population
     * @return array
     */
    private function calcRelativeFitness(array $population)
    {
        $returnValue = [];
        $sum = $this->calcFitnessSum($population);

        foreach ($population as $values) {
            $returnValue[] = [
                'chromosome' => $values['chromosome'],
                'fitnessAbsolute' => $values['fitnessAbsolute'],
                'fitnessRelative' => $values['fitnessAbsolute'] / $sum
            ];
        }

        return $returnValue;
    }

    /**
     * @param array $population
     * @return int
     */
    private function calcFitnessSum(array $population)
    {
        $sum = 0;
        foreach ($population as $values) {
            $sum += $values['fitnessAbsolute'];
        }

        return $sum;
    }

    /**
     * @param $population
     * @param ConfigurationValues $c
     * @return array
     * @throws SelectionException
     */
    private function selectPair($population, ConfigurationValues $c)
    {
        $spez1 = ['chromosome' => null];
        $spez2 = ['chromosome' => null];
        $counter = 1;

        while ($spez1['chromosome'] == $spez2['chromosome']) {
            $spez1 = $this->selectSpez($population);
            $this->notify(new SpezSelected($spez1), 'handleSpezSelected');

            $spez2 = $this->selectSpez($population);
            $this->notify(new SpezSelected($spez2), 'handleSpezSelected');

            if ($counter >= $c->maxSelectionAttempts) {
                throw new SelectionException($c->maxSelectionAttempts, $population);
            }
            $counter++;
        }

        return [$spez1, $spez2];
    }

    /**
     * @param array $population keys: ['chromosome', 'fitnessAbsolute', 'fitnessRelative']
     * @expects $population sorted ASC by 'fitnessRelative'
     * @return [$chromosome1, $chromosome2]
     */
    private function selectSpez($population)
    {
        $sum = $this->calcFitnessSum($population);
        // random_int return 0 or 1 so we have to use integer which can
        // represent our full precision
        // orig: $randWeight = random_int(0, 1000000000000000) / 1000000000000000;
        // to support random_int
        $factor = 1000000000;
        $randWeight = random_int(0, $factor) / $factor;

        foreach ($population as $index => $value) {
            $randWeight -= $value['fitnessRelative'];
            if ($randWeight <= 0) {
                return $population[$index];
            }
        }

        return $population[count($population) - 1];
    }

    /**
     * @param $spez1
     * @param $spez2
     * @param ConfigurationValues $c
     * @return array
     */
    private function sex($spez1, $spez2, ConfigurationValues $c)
    {
        // todo: mann: verify performance if only one child is returned
        // todo: mann: verify performance if only sometimes multiple childs are returned

        // @todo mann: verify performance if mutation only happens during recombination
        $random = random_int(0, 100) / 100;
        $child1 = '';
        $child2 = '';

        // recombination
        if ($random <= $c->crossoverRate) {
            // @todo mann: verify performance if recombinationPoint got new random number
            $length = array_sum(count_chars($spez1));
            $recombinationPoint = intval($length * $random);
            $child1 = substr($spez1, 0, $recombinationPoint) . substr($spez2, $recombinationPoint,
                    $length);
            $child2 = substr($spez2, 0, $recombinationPoint) . substr($spez1, $recombinationPoint,
                    $length);
        }

        // mutation: without we find the result in the first generation or nevert (local maximum???)
        $child1 = $this->mutate($child1, $c->mutationRate);
        $child2 = $this->mutate($child2, $c->mutationRate);

        return [$child1, $child2];
    }

    /**
     * @param $chromosome
     * @param $mutationRate
     * @return string
     */
    private function mutate($chromosome, $mutationRate)
    {
        $bits = str_split($chromosome);

        foreach ($bits as $pos => $bit) {
            $random = random_int(0, 1000000) / 1000000;
            if ($random <= $mutationRate) {
                $bit = ($bit == '1') ? '0' : '1';
                $bits[$pos] = $bit;
            }
        }

        return implode('', $bits);
    }
}

