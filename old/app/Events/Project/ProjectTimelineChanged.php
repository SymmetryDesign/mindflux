<?php

namespace App\Events\Project;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectTimelineChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The updated project instance.
     *
     * @var \App\Models\Project
     */
    public $project;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\Project $project
     */
    public function __construct($project)
    {
        $this->project = $project;
    }
}
