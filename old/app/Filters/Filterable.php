<?php

namespace App\Filters;

trait Filterable
{
    /**
     * Filter a result set.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \App\Filters\QueryFilter $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }
}
