<?php

namespace App\Http\Controllers\Web\Back\App;

use App\Filters\TaskFilter;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use Inertia\Inertia;

class TasksController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('tenant.user');
    }

    /**
     * Show my tasks page.
     *
     * @param \App\Filters\TaskFilter $filters
     * @return \Inertia\Response
     */
    public function index(TaskFilter $filters)
    {
        return Inertia::render('back/app/tasks/index', [
            'tasks'    => $this->getUserTasks($filters),
            'count'    => auth()->user()->tasks->count(),
            'users'    => User::orderBy('name')->get()->map->only(['uuid', 'name', 'avatar_url']),
            'projects' => $this->getUserProjects(),
        ]);
    }

    /**
     * Get user tasks.
     *
     * @param \App\Filters\TaskFilter $filters
     * @return \Illuminate\Support\Collection
     */
    protected function getUserTasks($filters)
    {
        return auth()->user()->tasks()
            ->with('user', 'column.project')
            ->filter($filters)
            ->orderBy('due_date', 'ASC')
            ->mainTasks()
            ->whereHas('column.project', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->get()
            ->transform(function ($task) {
                return [
                    'uuid'         => $task->uuid,
                    'content'      => $task->content,
                    'due_date'     => optional($task->due_date)->format('Y-m-d'),
                    'is_completed' => $task->isCompleted(),
                    'user_uuid'    => $task->user->uuid,
                    'priority'     => $task->priority,
                    'project'      => [
                        'uuid'  => $task->column->project->uuid,
                        'name'  => $task->column->project->name,
                        'color' => $task->column->project->color,
                    ]
                ];
            });
    }

    /**
     * Get user projects.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getUserProjects()
    {
        return Project::with('user', 'teamMembers')
            ->accessible()
            ->get()
            ->transform(function ($project) {
                return [
                    'uuid'  => $project->uuid,
                    'name'  => $project->name,
                    'color' => $project->color,
                ];
            });
    }
}
