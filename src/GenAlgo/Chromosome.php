<?php

namespace GenAlgo;


interface Chromosome
{
    /**
     * @param Chromosome $other
     * @return Chromosome[] outcome
     */
    public function crossover(Chromosome $other);

    public function mutate();

    public function calculateFitness();

}
