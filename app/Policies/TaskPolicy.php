<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        return $user->isTenantOwner();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Task $task
     * @return bool
     */
    public function view(User $user, Task $task)
    {
        return $task->column->project->isAccessible();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Project $project
     * @return bool
     */
    public function create(User $user, Project $project)
    {
        return $project->isAccessible();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Task $task
     * @return bool
     */
    public function update(User $user, Task $task)
    {
        return $task->project->isAccessible();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Task $task
     * @return bool
     */
    public function delete(User $user, Task $task)
    {
        return $task->column->project->isAccessible();
    }
}
