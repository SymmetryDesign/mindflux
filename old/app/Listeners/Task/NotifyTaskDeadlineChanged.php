<?php

namespace App\Listeners\Task;

use App\Models\Project;
use App\Notifications\Task\TaskDeadlineChanged;

class NotifyTaskDeadlineChanged
{
    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        $event->task->project->teamMembers->each(function ($user) use ($event) {
            if ($user->preferences()->get('email_notifications.task_deadline_changed', false) &&
                $event->task->project->isWatched($user)
            ) {
                $user->notify(new TaskDeadlineChanged($event->task));
            }
        });

        if ($event->task->project->visibility === Project::VISIBILITY_ORGANIZATION) {
            $event->task->project->watchers->each(function ($user) use ($event) {
                if ($user->preferences()->get('email_notifications.task_deadline_changed', false)) {
                    $user->notify(new TaskDeadlineChanged($event->task));
                }
            });
        }
    }
}
