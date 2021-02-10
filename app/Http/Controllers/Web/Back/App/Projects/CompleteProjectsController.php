<?php

namespace App\Http\Controllers\Web\Back\App\Projects;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class CompleteProjectsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('tenant.user');
        $this->middleware('plan.limit')->only('store', 'destroy');
    }

    /**
     * Mark the specified project as completed.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $project = Project::withTrashed()->where('uuid', $request->project)->firstOrFail();

        $this->authorize('update', $project);

        $project->markAsCompleted();

        session()->flash('message', 'The project has been updated');

        return back();
    }

    /**
     * Mark the specified project as incomplete.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Request $request)
    {
        $project = Project::withTrashed()->where('uuid', $request->project)->firstOrFail();

        $this->authorize('update', $project);

        $project->markAsIncomplete();

        session()->flash('message', 'The project has been updated');

        return back();
    }
}
