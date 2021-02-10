<?php

namespace App\Models;

use App\PreferenceManager;

trait HasPreference
{
    /**
     * Get all of model's preferences.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function modelPreferences()
    {
        return $this->morphMany(Preference::class, 'preferencable');
    }

    /**
     * Get an instance of preference manager.
     *
     * @return \App\PreferenceManager
     */
    public function preferences()
    {
        return new PreferenceManager($this);
    }
}
