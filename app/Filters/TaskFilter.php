<?php

namespace App\Filters;

use App\Models\Project;
use Illuminate\Support\Carbon;

class TaskFilter extends QueryFilter
{
    /**
     * Filter tasks by status.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function filter($query)
    {
        if ($query === 'today') {
            return $this->builder
                ->where('due_date', Carbon::today())
                ->incomplete();
        }

        if ($query === 'upcoming') {
            return $this->builder
                ->where('due_date', '>', Carbon::today())
                ->incomplete();
        }

        if ($query === 'no_overdue') {
            return $this->builder->whereNull('due_date');
        }

        if ($query === 'completed') {
            return $this->builder->completed();
        }

        if ($query === 'overdue') {
            return $this->builder->incomplete();
        }
    }

    /**
     * Filter tasks by project UUID.
     *
     * @param string $uuid
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function project($uuid)
    {
        if ($uuid) {
            $project = Project::where('uuid', $uuid)->firstOrFail()->id;

            return $this->builder
                ->whereHas('column', function ($query) use ($project) {
                    return $query->where('project_id', $project);
                });
        }
    }
}
