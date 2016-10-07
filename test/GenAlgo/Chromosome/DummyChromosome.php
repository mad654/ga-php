<?php


namespace GenAlgo\Chromosome;


class DummyChromosome extends AbstractBitChromosome
{
    public function __construct($code, \PHPUnit_Framework_MockObject_MockObject $random)
    {
        parent::__construct($code, $random);
        $this->randomGenerator = $random;
    }


    public function pos($pos) {
        $this->randomGenerator->method('get')->willReturn($pos);
        return $this;
    }

    public function calculateFitness()
    {
        // TODO: Implement calculateFitness() method.
    }
}
