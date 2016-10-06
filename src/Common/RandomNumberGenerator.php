<?php


namespace Common;


class RandomNumberGenerator
{
    /**
     * @param int $min
     * @param int $max
     * @return int
     */
    public function get($min = 0, $max = 1) {
        return random_int($min, $max);
    }
}
