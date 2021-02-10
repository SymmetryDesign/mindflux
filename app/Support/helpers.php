<?php

use App\Models\Plan;
use App\Support\Date;
use App\Support\Filesize;
use App\Support\Settings;

/**
 * Get current authenticated tenant instance.
 *
 * @return \App\Models\Tenant
 */
function tenant()
{
    if (auth()->check()) {
        return auth()->user()->tenant;
    }
}

/**
 * Determine if the free plan is enabled.
 *
 * @return bool
 */
function free_plan_enabled()
{
    return Plan::where('is_default', true)
            ->where('price', 0)
            ->where('status', Plan::STATUS_ACTIVE)
            ->count() > 0;
}

/**
 * Determine if the limits of current plan has been exceeded.
 *
 * @return bool
 */
function plan_limits_exceeded()
{
    return tenant()->exceededPlanLimits();
}

/**
 * Settings helper function.
 *
 * @param null $key
 * @param null $default
 * @return Settings|array|string|null
 */
function settings($key = null, $default = null)
{
    if ($key === null) {
        return app(Settings::class);
    }

    if (is_array($key)) {
        app(Settings::class)->put($key, $default);
    } else {
        return app(Settings::class)->get($key, $default);
    }
}

/**
 * Determine day name from the given integer.
 *
 * @param int $num
 * @return string
 */
function day_from_int($num)
{
    return Date::dayFromInt($num);
}

/**
 * Determine month name from the given integer.
 *
 * @param int $num
 * @return string
 */
function month_from_int($num)
{
    return Date::monthFromInt($num);
}

/**
 * Convert bytes to MB.
 *
 * @param float $bytes
 * @return float
 */
function bytes_to_mb($bytes)
{
    return Filesize::bytesToMB($bytes);
}

/**
 * Get faker instance.
 *
 * @return \Faker\Generator
 */
function faker()
{
    return Faker\Factory::create();
}
