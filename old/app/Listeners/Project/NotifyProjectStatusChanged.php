<?php

namespace App\Listeners\Project;

use App\Models\Project;
use App\Notifications\Project\ProjectStatusChanged;

class NotifyProjectStatusChanged
{
    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        $event->project->teamMembers->each(function ($user) use ($event) {
            if ($user->preferences()->get('email_notifications.project_status_changed', false) &&
                $event->project->isWatched($user)
            ) {
                $user->notify(new ProjectStatusChanged($event->project));
            }
        });

        if ($event->project->visibility === Project::VISIBILITY_ORGANIZATION) {
            $event->project->watchers->each(function ($user) use ($event) {
                if ($user->preferences()->get('email_notifications.project_status_changed', false)) {
                    $user->notify(new ProjectStatusChanged($event->project));
                }
            });
        }
    }
}
