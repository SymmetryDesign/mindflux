<?php

namespace App\Listeners\Task;

use App\Models\Project;
use App\Notifications\Task\TaskStatusChanged;

class NotifyTaskStatusChanged
{
    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        $project = $event->task->project;

        $project->teamMembers->each(function ($user) use ($event, $project) {
            if ($user->preferences()->get('email_notifications.task_status_changed', false) &&
                $project->isWatched($user)
            ) {
                $user->notify(new TaskStatusChanged($event->task));
            }
        });

        if ($project->visibility === Project::VISIBILITY_ORGANIZATION) {
            $project->watchers->each(function ($user) use ($event) {
                if ($user->preferences()->get('email_notifications.task_status_changed', false)) {
                    $user->notify(new TaskStatusChanged($event->task));
                }
            });
        }
    }
}
