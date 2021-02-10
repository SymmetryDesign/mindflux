<?php

namespace App\Providers;

use App\Events\Project\ProjectAssignedToUser;
use App\Events\Project\ProjectStatusChanged;
use App\Events\Project\ProjectTimelineChanged;
use App\Events\Task\TaskAssignedToUser;
use App\Events\Task\TaskDeadlineChanged;
use App\Events\Task\TaskPhaseChanged;
use App\Events\Task\TaskStatusChanged;
use App\Listeners\Project\NotifyAssignedToProject;
use App\Listeners\Project\NotifyProjectStatusChanged;
use App\Listeners\Project\NotifyProjectTimelineChanged;
use App\Listeners\Project\NotifyTeamMemberJoined;
use App\Listeners\Task\NotifyAssignedToTask;
use App\Listeners\Task\NotifyAssignedToTeamMember;
use App\Listeners\Task\NotifyTaskDeadlineChanged;
use App\Listeners\Task\NotifyTaskPhaseChanged;
use App\Listeners\Task\NotifyTaskStatusChanged;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        ProjectAssignedToUser::class => [
            NotifyAssignedToProject::class,
            NotifyTeamMemberJoined::class,
        ],

        ProjectStatusChanged::class => [
            NotifyProjectStatusChanged::class,
        ],

        ProjectTimelineChanged::class => [
            NotifyProjectTimelineChanged::class,
        ],

        TaskAssignedToUser::class => [
            NotifyAssignedToTask::class,
            NotifyAssignedToTeamMember::class,
        ],

        TaskStatusChanged::class => [
            NotifyTaskStatusChanged::class,
        ],

        TaskPhaseChanged::class => [
            NotifyTaskPhaseChanged::class,
        ],

        TaskDeadlineChanged::class => [
            NotifyTaskDeadlineChanged::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
