<?php

namespace GenAlgo;

class SelectionException extends \Exception
{
  public function __construct($maxSelectionAttemps, $population) {
    $message = "'Max selection attemps reached: $maxSelectionAttemps. ";
    $message .= "We can not find 2 different species in population' ";
    $message .= json_encode($population);

    parent::__construct($message, 404);
  }
}
