<?php

namespace GenAlgo\SimpleAlgorithm;

class SimpleCode
{
  private $code;
  private $genLength;

  public function __construct(array $code) {
    $this->code = $code;
    reset($this->code);
    $this->genLength = array_sum(count_chars(key($this->code)));
  }

  public function randomGen() {
    $codes = array_keys($this->code);
    $index = rand( 0, count($this->code) - 1 );
    return $codes[$index];
  }

  public function decode($chromosome) {
    $tokens = str_split($chromosome, $this->genLength);
    $result = [];

    foreach ($tokens as $token) {
        if (!isset($this->code[$token])) {
          continue;
        }

        $result[] = $this->code[$token];
    }

    return implode('', $result);
  }
}
