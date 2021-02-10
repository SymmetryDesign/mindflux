<?php

namespace App\Http\Controllers\Web\Back\App\Projects;

use App\Events\Project\ProjectAssignedToUser;
use App\Events\Project\ProjectTimelineChanged;
use App\Filters\ProjectFilter;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('tenant.user');
        $this->middleware('plan.limit')->only('store', 'update');
    }

    /**
     * Show a listing of all projects.
     *
     * @param \App\Filters\ProjectFilter $filters
     * @return \Inertia\Response
     */
    public function index(ProjectFilter $filters)
    {
        return Inertia::render('back/app/projects/index', [
            'filters'  => request()->all('visibility', 'status', 'search'),
            'users'    => User::orderBy('name')->get()->map->only(['uuid', 'name', 'email', 'avatar_url']),
            'projects' => Project::with('teamMembers', 'user', 'tasks')
                ->filter($filters)
                ->accessible()
                ->latest()
                ->paginate(10)
                ->transform(function ($project) {
                    return [
                        'uuid'          => $project->uuid,
                        'name'          => $project->name,
                        'description'   => $project->description,
                        'status'        => $project->status,
                        'pending_tasks' => $project->tasks()->pending()->count(),
                        'days_left'     => $project->days_left,
                        'team_members'  => $project->teamMembers->transform(function ($user) {
                            return [
                                'name'       => $user->name,
                                'avatar_url' => $user->avatar_url,
                            ];
                        })
                    ];
                })
        ]);
    }

    /**
     * Show project page.
     *
     * @param \Illuminate\Http\ Request $request
     * @return \Inertia\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Request $request)
    {
        $project = Project::with('columns', 'columns.tasks', 'columns.tasks.user', 'user', 'teamMembers')
            ->where('uuid', $request->project)
            ->withTrashed()
            ->firstOrFail();

        $this->authorize('view', $project);

        return Inertia::render('back/app/projects/show', [
            'users'   => User::orderBy('name')->get()->map->only(['uuid', 'name', 'email', 'avatar_url']),
            'can'     => [
                'update_project'  => auth()->user()->can('update', $project),
                'archive_project' => auth()->user()->can('delete', $project),
                'delete_project'  => auth()->user()->can('forceDelete', $project),
            ],
            'project' => [
                'uuid'         => $project->uuid,
                'name'         => $project->name,
                'description'  => $project->description,
                'visibility'   => $project->visibility,
                'timeline'     => $project->timeline,
                'color'        => $project->color,
                'status'       => $project->status,
                'team_members' => $project->teamMembers->pluck('uuid'),
                'is_favorite'  => $project->isFavorite(),
                'is_archived'  => $project->trashed(),
                'is_completed' => $project->isCompleted(),
                'is_watched'   => $project->isWatched(),
                'columns'      => $project->columns->sortBy('index')->map(function ($column) {
                    return [
                        'uuid'  => $column->uuid,
                        'name'  => $column->name,
                        'index' => $column->index,
                        'tasks' => $column->tasks()->mainTasks()->get()->sortByDesc('index')->transform(function ($task) {
                            return [
                                'uuid'         => $task->uuid,
                                'content'      => $task->content,
                                'index'        => $task->index,
                                'due_date'     => optional($task->due_date)->format('Y-m-d'),
                                'priority'     => $task->priority,
                                'is_completed' => $task->isCompleted(),
                                'user'         => [
                                    'uuid'       => optional($task->user)->uuid,
                                    'name'       => optional($task->user)->name,
                                    'avatar_url' => optional($task->user)->avatar_url,
                                ],
                                'sub_tasks'    => [
                                    'total'     => $task->tasks()->subTasks()->count(),
                                    'completed' => $task->tasks()->subTasks()->completed()->count(),
                                ]
                            ];
                        })->values()
                    ];
                })->values()
            ]
        ]);
    }

    /**
     * Store a new created project.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'visibility'  => ['required'],
            'color'       => ['required'],
        ]);

        $project = Project::create([
            'name'        => $request->input('name'),
            'description' => $request->input('description'),
            'color'       => $request->input('color'),
            'visibility'  => $request->input('visibility'),
            'user_id'     => auth()->user()->id,
            'tenant_id'   => tenant()->id,
        ]);

        $this->updateProjectTimeline($project, $request);

        $this->syncProjectTeamMembers($project, $request);

        session()->flash('message', __('app.messages.project-created'));

        return back();
    }

    /**
     * Update an existing project.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name'        => ['required', 'string'],
            'description' => ['required', 'string'],
            'visibility'  => ['required'],
            'color'       => ['required']
        ]);

        $project = Project::where('uuid', $request->project)->firstOrFail();

        $this->authorize('update', $project);

        $project->update([
            'name'        => $request->input('name'),
            'description' => $request->input('description'),
            'color'       => $request->input('color'),
            'visibility'  => $request->input('visibility'),
        ]);

        $this->updateProjectTimeline($project, $request);

        $this->syncProjectTeamMembers($project, $request);

        session()->flash('message', __('app.messages.project-updated'));

        return back();
    }

    /**
     * Delete an existing project.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(Request $request)
    {
        $project = Project::withTrashed()->where('uuid', $request->project)->firstOrFail();

        if ($project->trashed()) {
            $this->authorize('forceDelete', $project);
            $project->forceDelete();
            session()->flash('message', __('app.messages.project-deleted'));
        } else {
            $this->authorize('delete', $project);
            $project->delete();
            session()->flash('message', __('app.messages.project-archived'));
        }

        return redirect()->route('app:projects.index');
    }

    /**
     * Restore an archived project.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function restore(Request $request)
    {
        $project = Project::where('uuid', $request->project)->onlyTrashed()->firstOrFail();

        $this->authorize('restore', $project);

        $project->restore();

        session()->flash('message', __('app.messages.project-restored'));

        return redirect()->route('app:projects.index');
    }

    /**
     * Sync project team members.
     *
     * @param \App\Models\Project $project
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    protected function syncProjectTeamMembers($project, $request)
    {
        if ($project->visibility !== Project::VISIBILITY_TEAM_MEMBERS) {
            $project->teamMembers()->sync([]);

            return;
        }

        if ($request->input('team_members') === null) {
            return $project->teamMembers()->sync([]);;
        }

        $oldTeamMembers = $project->teamMembers;

        $newTeamMembers = User::whereIn('uuid', $request->input('team_members'))->get();
        $project->teamMembers()->sync($newTeamMembers->pluck('id'));

        $project->refresh();

        collect($newTeamMembers->whereNotIn('id', $oldTeamMembers->pluck('id')->toArray())->all())
            ->pipe(function ($newTeamMembers) use ($project) {
                if ($newTeamMembers->count()) {
                    event(new ProjectAssignedToUser($newTeamMembers, $project));
                }
            });
    }

    /**
     * Update the start and end dates of the project.
     *
     * @param \App\Models\Project $project
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    protected function updateProjectTimeline($project, $request)
    {
        if ($request->input('timeline') !== null) {
            $period = Carbon::period($request->input('timeline'));

            $project->update([
                'start_date' => optional($period)->start,
                'end_date'   => optional($period)->end,
            ]);
        } else {
            $project->update([
                'start_date' => null,
                'end_date'   => null,
            ]);
        }

        if ($project->wasChanged('start_date') || $project->wasChanged('end_date')) {
            event(new ProjectTimelineChanged($project));
        }
    }
}
