<?php

namespace GenAlgo;

class SelectionException extends \Exception
{
    /**
     * @var array
     */
    private $errorPopulation;

    /**
     * SelectionException constructor.
     * @param string $maxSelectionAttemps
     * @param array $population
     */
    public function __construct($maxSelectionAttemps, $population) {
        $this->errorPopulation = $population;

        $message = "'Max selection attemps reached: $maxSelectionAttemps. ";
        $message .= "We can not find 2 different species in population' ";

        parent::__construct($message, 404);
    }

    /**
     * @return array
     */
    public function getErrorPopulation()
    {
        return $this->errorPopulation;
    }
}
