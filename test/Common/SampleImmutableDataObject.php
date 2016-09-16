<?php


namespace Common;


class SampleImmutableDataObject
{
    use ImmutableDataObjectTrait;

    public $firstname;
    public $lastname;

    /**
     * SampleImmutableDataObject constructor.
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
