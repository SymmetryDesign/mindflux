<?php

namespace App\Billing;

use Illuminate\Support\Facades\Facade as Base;

class Facade extends Base
{
    /**
     * Register facade accessor name.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'billing';
    }
}
