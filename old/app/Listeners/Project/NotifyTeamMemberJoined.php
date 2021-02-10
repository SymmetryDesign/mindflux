<?php

namespace App\Listeners\Project;

use App\Notifications\Project\TeamMemberJoined;

class NotifyTeamMemberJoined
{
    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        $event->project->teamMembers->whereNotIn('id', $event->users->pluck('id')->toArray())
            ->pipe(function ($users) use ($event) {
                return $users->filter(function ($user) use ($event) {
                    return $event->project->isWatched($user) &&
                        $user->preferences()->get('email_notifications.team_member_joined_project', false);
                });
            })
            ->each(function ($userToNotify) use ($event) {
                $userToNotify->notify(
                    new TeamMemberJoined($event->users, $event->project)
                );
            });
    }
}
