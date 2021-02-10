<?php

namespace App\Http\Controllers\Web\Back\App;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Inertia\Inertia;

class DashboardController extends Controller
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
     * Show the application dashboard page.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $tasks = auth()->user()->tasks;
        $completedTasksByMonth = $this->getCompletedTasksByMonth();
        $completedTasksByDay = $this->getCompletedTasksByDay();

        return Inertia::render('back/app/dashboard', [
            'stats'                 => [
                'projects'        => Project::accessible()->count(),
                'total_tasks'     => $tasks->count(),
                'open_tasks'      => $tasks->where('completed_at', null)->count(),
                'completed_tasks' => $tasks->where('completed_at', '!=', null)->count(),
            ],
            'tasks_by_month'        => $completedTasksByMonth,
            'tasks_by_month_count'  => collect($completedTasksByMonth)->sum(),
            'tasks_by_day'          => $completedTasksByDay,
            'tasks_by_day_count'    => collect($completedTasksByDay)->sum(),
            'most_productive_month' => month_from_int($completedTasksByMonth->search($completedTasksByMonth->max(), true)),
            'most_productive_day'   => day_from_int($completedTasksByDay->search($completedTasksByDay->max(), true))
        ]);
    }

    /**
     * Get completed tasks by month for the current year.
     *
     * @return array
     */
    protected function getCompletedTasksByMonth()
    {
        $tasks = collect()->pad(12, 0);

        auth()->user()->tasks()
            ->completed()
            ->whereYear('completed_at', date('Y'))
            ->get()
            ->groupBy(function ($task) {
                return $task->completed_at->format('m');
            })
            ->map
            ->count()
            ->each(function ($value, $key) use ($tasks) {
                $tasks->put(intval($key) - 1, $value);
            });

        return $tasks;
    }

    /**
     * Most productive days for current year.
     *
     * @return array
     */
    protected function getCompletedTasksByDay()
    {
        $tasks = collect()->pad(7, 0);

        auth()->user()->tasks()
            ->completed()
            ->get()
            ->groupBy(function ($task) {
                return $task->completed_at->format('w');
            })
            ->map
            ->count()
            ->each(function ($value, $key) use ($tasks) {
                $tasks->put(intval($key), $value);
            });

        return $tasks;
    }
}
