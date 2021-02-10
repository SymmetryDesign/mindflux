<?php

namespace App\Http\Controllers\Web\Back\App\Projects;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectWatchersController extends Controller
{
    /**
     * Start watching the specified project.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $project = Project::where('uuid', $request->project)->firstOrFail();

        if (!$project->isWatched()) {
            $project->watchers()->save(
                auth()->user()
            );
        }

        session()->flash('message', __('app.messages.started-watching-project'));

        return back();
    }

    /**
     * Stop watching the specified project.
     *
     * @param \Illuminate\Http\Request $request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $project = Project::where('uuid', $request->project)->firstOrFail();

        if ($project->isWatched()) {
            $project->watchers()->detach(
                auth()->user()
            );
        }

        session()->flash('message', __('app.messages.stopped-watching-project'));

        return back();
    }
}
