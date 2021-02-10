<?php

namespace App\Http\Controllers\Web\Back\App;

use App\Http\Controllers\Controller;
use App\Models\User;

class CalendarController extends Controller
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
     * Show calendar page.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia('back/app/calendar/index', [
            'users'  => User::orderBy('name')->get()->map->only(['uuid', 'name', 'avatar_url']),
            'events' => auth()->user()->tasks()
                ->mainTasks()
                ->whereHas('column.project', function ($query) {
                    $query->whereNull('deleted_at');
                })
                ->get()
                ->transform(function ($task) {
                    return [
                        'uuid'         => $task->uuid,
                        'title'        => $task->content,
                        'date'         => $task->due_date,
                        'project_uuid' => $task->column->project->uuid,
                        'color'        => $task->column->project->color,
                        'is_completed' => $task->isCompleted(),
                        'classNames'   => $task->isCompleted() ? 'line-through' : '',
                        'user_uuid'    => optional($task->user)->uuid,
                        'priority'     => $task->priority,
                    ];
                })
        ]);
    }
}
