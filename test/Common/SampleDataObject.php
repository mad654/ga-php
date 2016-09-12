<?php


namespace Common;


class SampleDataObject
{
    use DataObjectTrait;

    public $firstname;
    public $lastname;

    /**
     * SampleDataObject constructor.
     * @param $firstname
     * @param $lastname
     */
    public function __construct($firstname, $lastname)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;

        $this->freeze();
    }


}
