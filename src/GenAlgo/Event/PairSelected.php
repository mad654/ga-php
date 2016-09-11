<?php


namespace GenAlgo\Event;


use Common\AbstractDataObject;

class PairSelected extends AbstractDataObject
{

    private $spez1;
    private $spez2;

    /**
     * PairSelected constructor.
     * @param $spez1
     * @param $spez2
     */
    public function __construct($spez1, $spez2)
    {
        $this->spez1 = $spez1;
        $this->spez2 = $spez2;
    }

    /**
     * @return mixed
     */
    public function getSpez1()
    {
        return $this->spez1;
    }

    /**
     * @return mixed
     */
    public function getSpez2()
    {
        return $this->spez2;
    }

}
