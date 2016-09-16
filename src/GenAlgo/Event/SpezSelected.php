<?php


namespace GenAlgo\Event;


use Common\ArrayAble;
use Common\ImmutableDataObjectTrait;

class SpezSelected implements ArrayAble
{
    use ImmutableDataObjectTrait;

    public $spez;

    /**
     * SpezSelected constructor.
     * @param mixed $spez
     */
    public function __construct($spez)
    {
        $this->spez = $spez;
        $this->freeze();
    }

}
