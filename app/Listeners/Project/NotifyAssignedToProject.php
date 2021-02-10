<?php

namespace App\Listeners\Project;

use App\Notifications\Project\AssignedToProject;

class NotifyAssignedToProject
{
    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        $event->users->each(function ($user) use ($event) {
            if ($user->preferences()->get('email_notifications.assigned_to_project', false)) {
                $user->notify(new AssignedToProject($event->project));
            }
        });
    }
}
