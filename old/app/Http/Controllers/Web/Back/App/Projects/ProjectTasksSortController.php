<?php

namespace App\Http\Controllers\Web\Back\App\Projects;

use App\Events\Task\TaskPhaseChanged;
use App\Http\Controllers\Controller;
use App\Models\Column;
use App\Models\Task;
use Illuminate\Http\Request;

class ProjectTasksSortController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware([
            'tenant.user', 'plan.limit'
        ]);
    }

    /**
     * Update the sorting of the specified tasks.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request)
    {
        $column = Column::where('uuid', $request->column)->firstOrFail();

        $this->authorize('view', $column->project);

        $oldTasks = $column->tasks;

        collect($request->input('tasks'))->each(function ($task, $index) use ($column) {
            $task = Task::where('uuid', $task)->firstOrFail();

            $this->authorize('update', $task);

            $task->update([
                'index'     => $index,
                'column_id' => $column->id,
            ]);
        });

        $column->refresh();

        $column->tasks->whereNotIn('id', $oldTasks->pluck('id')->toArray())->each(function ($task) {
            event(new TaskPhaseChanged($task));
        });

        return back();
    }
}
