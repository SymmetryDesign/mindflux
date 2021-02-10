<?php

namespace App\Policies;

use App\Models\Column;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ColumnPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Column $column
     * @return bool
     */
    public function update(User $user, Column $column)
    {
        return $column->project->isAccessible();
    }
}
