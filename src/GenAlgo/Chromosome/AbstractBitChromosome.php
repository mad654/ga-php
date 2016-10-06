<?php


namespace GenAlgo\Chromosome;


use Common\RandomNumberGenerator;
use GenAlgo\Chromosome;

abstract class AbstractBitChromosome implements Chromosome
{
    /**
     * @var string of bits
     */
    private $code;

    /**
     * @var RandomNumberGenerator
     */
    private $randomNumberGenerator;

    /**
     * AbstractBitChromosome constructor.
     * @param $code
     * @param RandomNumberGenerator $randomNumberGenerator
     */
    public function __construct($code, RandomNumberGenerator $randomNumberGenerator)
    {
        $this->code = $code;
        $this->randomNumberGenerator = $randomNumberGenerator;
    }


    public function crossover(Chromosome $other)
    {
        $length = array_sum(count_chars($this->code));
        $length2 = array_sum(count_chars($other->code));
        if ($length2 < $length) {
            $length = $length2;
        }

        $pos = $this->randomNumberGenerator->get(0, $length);
        $code1part1 = '';
        if ($pos > 0) {
            $code1part1 = substr($this->code, 0, $pos);
        }

        $code2part1 = '';
        if ($pos > 0) {
            $code2part1 = substr($other->code, 0, $pos);
        }

        $outcome1 = $code1part1 . substr($other->code, $pos, $length);
        $outcome2 = $code2part1 . substr($this->code, $pos, $length);

        return [
            new static($outcome1, $this->randomNumberGenerator),
            new static($outcome2, $this->randomNumberGenerator)
        ];
    }

}
