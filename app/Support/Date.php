<?php

namespace App\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class Date
{
    /**
     * List of months.
     *
     * @var array
     */
    const MONTHS = [
        'January', 'Febuary', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    ];

    /**
     * Determine day name from given integer.
     *
     * @param int $num
     * @return string
     */
    public static function dayFromInt($num)
    {
        return Arr::get(Carbon::getDays(), $num);
    }

    /**
     * Determine month name from given integer.
     *
     * @param int $num
     * @return string
     */
    public static function monthFromInt($num)
    {
        return Arr::get(self::MONTHS, $num);
    }
}
