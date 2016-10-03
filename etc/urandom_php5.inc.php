<?php
/**
 *
 * equiv to rand, mt_rand but uses /dev/urandom
 * returns int in *closed* interval [$min,$max]
 *
 * @param int $min
 * @param int $max
 * @return float
 */
function random_int($min = 0, $max = 0x7FFFFFFF) {
    $diff = $max - $min;
    if ($diff < 0 || $diff > 0x7FFFFFFF) {
        throw new RuntimeException("Bad range");
    }
    $bytes = mcrypt_create_iv(4, MCRYPT_DEV_URANDOM);
    if ($bytes === false || strlen($bytes) != 4) {
        throw new RuntimeException("Unable to get 4 bytes");
    }
    $ary = unpack("Nint", $bytes);
    $val = $ary['int'] & 0x7FFFFFFF;   // 32-bit safe
    $fp = (float) $val / 2147483647.0; // convert to [0,1]
    return round($fp * $diff) + $min;
}
