<?php

namespace App\Support;

class Filesize
{
    /**
     * Convert bytes to MB.
     *
     * @param float $bytes
     * @return float
     */
    public static function bytesToMB($bytes)
    {
        return $bytes * 0.000001;
    }
}
