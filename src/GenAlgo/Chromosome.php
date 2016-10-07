<?php

namespace GenAlgo;


interface Chromosome
{
    /**
     * @param Chromosome $other
     * @return Chromosome[] outcome
     */
    public function crossover(Chromosome $other);

    /**
     * @param float $rate value between 0.0 and 1.0
     * @return Chromosome
     */
    public function mutate($rate);

    public function calculateFitness();

}
