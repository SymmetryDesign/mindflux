<?php

namespace App\Events\Project;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectAssignedToUser
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The assigned users collection.
     *
     * @var \Illuminate\Support\Collection
     */
    public $users;

    /**
     * The assigned project instance.
     *
     * @var \App\Models\Project
     */
    public $project;

    /**
     * Create a new event instance.
     *
     * @param \Illuminate\Support\Collection $users
     * @param \App\Models\Project $project
     */
    public function __construct($users, $project)
    {
        if ($users instanceof \App\Models\User) {
            $users = collect($users);
        }

        $this->users = $users;

        $this->project = $project;
    }
}
