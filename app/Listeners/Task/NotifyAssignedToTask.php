<?php

namespace App\Listeners\Task;

use App\Notifications\Task\AssignedToTask;

class NotifyAssignedToTask
{
    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        if ($event->user->preferences()->get('email_notifications.task_assigned_to_you', false) &&
            $event->task->project->isWatched($event->user)
        ) {
            $event->user->notify(new AssignedToTask($event->task));
        }
    }
}
