<?php

namespace App\Models;

class Plan extends Model
{
    /**
     * Indicates an active plan.
     *
     * @var int
     */
    const STATUS_ACTIVE = 1;

    /**
     * Indicates inactive plan.
     *
     * @var int
     */
    const STATUS_INACTIVE = 2;

    /**
     * Filter all active plans.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeActive($query)
    {
        $query->where('status', Plan::STATUS_ACTIVE);
    }

    /**
     * The plan has many subscriptions
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Get free plan model instance.
     *
     * @return \App\Models\Plan
     */
    public static function free()
    {
        return Plan::where('is_default', true)
            ->where('price', 0)
            ->where('status', Plan::STATUS_ACTIVE)
            ->first();
    }

    /**
     * Determine if free plan is enabled.
     *
     * @return bool
     */
    public static function freeEnabled()
    {
        return Plan::free() !== null;
    }
}
