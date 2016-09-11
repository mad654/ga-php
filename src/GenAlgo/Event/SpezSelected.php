<?php


namespace GenAlgo\Event;


use Common\AbstractDataObject;

class SpezSelected extends AbstractDataObject
{
    /**
     * @var mixed
     */
    private $spez;

    /**
     * SpezSelected constructor.
     * @param mixed $spez
     */
    public function __construct($spez)
    {
        $this->spez = $spez;
    }

    /**
     * @return mixed
     */
    public function getSpez()
    {
        return $this->spez;
    }

}
