<?php


namespace GenAlgo\Event;


use Common\ArrayAble;
use Common\ImmutableDataObjectTrait;

class PopulationCreated implements ArrayAble
{
    use ImmutableDataObjectTrait;

    /**
     * @var int
     */
    public $generation;

    /**
     * @var array
     */
    public $population;

    /**
     * PopulationCreated constructor.
     * @param int $generation
     * @param array $population
     */
    public function __construct($generation, $population)
    {
        $this->generation = $generation;
        $this->population = $population;
        $this->freeze();
    }
}
