<?php

namespace App\Filters;

use App\Models\User;

class TenantFilter extends QueryFilter
{
    /**
     * Filter tenants by search query.
     *
     * @param string $query
     * @return void
     */
    public function search($query)
    {
        if (strlen($query) > 1) {
            $this->builder->where('name', 'LIKE', "%$query%")
                ->orWhereHas('users', function ($builder) use ($query) {
                    $builder->where('role', User::ROLE_TENANT_OWNER)
                        ->where('email', 'LIKE', "%$query%");
                });
        }
    }

    /**
     * Filter tenants by subscription status.
     *
     * @param $code
     * @return void
     */
    public function status($code)
    {
        if ($code === 'active') {
            $this->builder->whereHas('subscriptions', function ($builder) {
                $builder->active();
            });
        }

        if ($code === 'previous') {
            $this->builder->whereHas('subscriptions', function ($builder) {
                $builder->canceled();
            });
        }
    }
}
