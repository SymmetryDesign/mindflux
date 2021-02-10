<?php

namespace App\Models;

class Preference extends Model
{
    /**
     * Get the owning preferencable model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function preferencable()
    {
        return $this->morphTo();
    }
}
