<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Base;

abstract class Model extends Base
{
    /**
     * The attributes that are guarded from mass assignment.
     *
     * @var array
     */
    protected $guarded = [];
}
