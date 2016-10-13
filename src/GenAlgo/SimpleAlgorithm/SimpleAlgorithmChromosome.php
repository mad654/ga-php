<?php


namespace GenAlgo\SimpleAlgorithm;


use Common\RandomNumberGenerator;
use GenAlgo\Chromosome\AbstractBitChromosome;

class SimpleAlgorithmChromosome extends AbstractBitChromosome
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

    /**
     * @var int
     */
    private $searched;

    /**
     * @var SimpleCode
     */
    private $code;

    public function __construct($code, RandomNumberGenerator $randomNumberGenerator)
    {
        parent::__construct($code, $randomNumberGenerator);
        $this->code = new SimpleCode(self::CODE);
    }

    /**
     * @return mixed
     */
    public function getSearched()
    {
        return $this->searched;
    }

    /**
     * @param mixed $searched
     */
    public function setSearched($searched)
    {
        $this->searched = $searched;
    }

    /**
     * @return float
     * @throws SolutionException
     */
    public function calculateFitness()
    {
        $decoded = $this->code->decode((string) $this);

        $valid = $this->cleanUp($decoded);
        $result = eval("return $valid;");

        $difference = $this->searched - $result;
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
}
