<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Project $project
     * @return bool
     */
    public function view(User $user, Project $project)
    {
        return $project->isAccessible();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Project $project
     * @return bool
     */
    public function update(User $user, Project $project)
    {
        return $project->user_id === $user->id || $user->isTenantOwner();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Project $project
     * @return bool
     */
    public function delete(User $user, Project $project)
    {
        return $project->user_id === $user->id || $user->isTenantOwner();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Project $project
     * @return bool
     */
    public function forceDelete(User $user, Project $project)
    {
        return $user->isTenantOwner();
    }

    /**
     * Determine whether the user can restore the project.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Project $project
     * @return bool
     */
    public function restore(User $user, Project $project)
    {
        return $project->user_id === $user->id || $user->isTenantOwner();
    }
}
