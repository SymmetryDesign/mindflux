<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

trait MultiTenantable
{
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        if (app()->runningInConsole()) {
            return;
        }

        if (auth()->check() && !auth()->user()->isAdmin()) {
            $tenantId = auth()->user()->tenant_id;

            static::addGlobalScope('tenant_id', function (Builder $builder) use ($tenantId) {
                $builder->where('tenant_id', $tenantId);
            });
        }
    }
}
