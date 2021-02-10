<?php

namespace App\Listeners\Task;

use App\Models\Project;
use App\Notifications\Task\TaskAssignedToTeamMember;

class NotifyAssignedToTeamMember
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

        $project->teamMembers->whereNotIn('id', $event->user->id)->each(function ($user) use ($event, $project) {
            if ($user->preferences()->get('email_notifications.task_assigned_to_team_member', false) &&
                $project->isWatched($user)
            ) {
                $user->notify(new TaskAssignedToTeamMember($event->task, $event->user));
            }
        });

        if ($project->visibility === Project::VISIBILITY_ORGANIZATION) {
            $project->watchers->each(function ($user) use ($event) {
                if ($user->preferences()->get('email_notifications.task_assigned_to_team_member', false)) {
                    $user->notify(new TaskAssignedToTeamMember($event->task, $event->user));
                }
            });
        }
    }
}
