<?php


namespace GenAlgo\Event;


use Common\ArrayAble;
use Common\ImmutableDataObjectTrait;

class PairSelected implements ArrayAble
{
    use ImmutableDataObjectTrait;

    public $spez1;
    public $spez2;

    /**
     * PairSelected constructor.
     * @param $spez1
     * @param $spez2
     */
    public function __construct($spez1, $spez2)
    {
        $this->spez1 = $spez1;
        $this->spez2 = $spez2;
        $this->freeze();
    }
}
