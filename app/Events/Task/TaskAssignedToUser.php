<?php

namespace App\Events\Task;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskAssignedToUser
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The asssigned task instance.
     *
     * @var \App\Models\Task
     */
    public $task;

    /**
     * The assigned user instance.
     *
     * @var \App\Models\User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\Task $task
     * @param \App\Models\User $user
     */
    public function __construct($task, $user)
    {
        $this->task = $task;
        $this->user = $user;
    }
}
