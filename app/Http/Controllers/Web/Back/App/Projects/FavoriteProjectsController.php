<?php

namespace App\Http\Controllers\Web\Back\App\Projects;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class FavoriteProjectsController extends Controller
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
     * Add the project to the favorite projects of the user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $project = Project::where('uuid', $request->project)->firstOrFail();

        $this->authorize('view', $project);

        auth()->user()->favoriteProjects()->attach($project);

        return back();
    }

    /**
     * Remove the project from the favorite projects of the user.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Request $request)
    {
        $project = Project::where('uuid', $request->project)->firstOrFail();

        $this->authorize('view', $project);

        auth()->user()->favoriteProjects()->detach($project);

        return back();
    }
}
