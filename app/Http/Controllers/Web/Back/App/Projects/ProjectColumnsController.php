<?php

namespace App\Http\Controllers\Web\Back\App\Projects;

use App\Http\Controllers\Controller;
use App\Models\Column;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectColumnsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('tenant.user');
        $this->middleware('plan.limit')->only('store', 'update', 'destroy');
    }

    /**
     * Store a new created column.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:255'],
        ]);

        $project = Project::where('uuid', $request->project)->firstOrFail();

        $this->authorize('view', $project);

        $project->columns()->create([
            'name'  => $request->input('name'),
            'index' => $project->columns->count(),
        ]);

        return back();
    }

    /**
     * Update an existing project column.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:255'],
        ]);

        $column = Column::where('uuid', $request->column)->firstOrFail();

        $this->authorize('view', $column->project);

        $column->update([
            'name' => $request->input('name'),
        ]);

        return back();
    }

    /**
     * Delete an existing project column.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Request $request)
    {
        $column = Column::where('uuid', $request->column)->firstOrFail();

        $this->authorize('view', $column->project);

        $column->delete();

        return back();
    }
}
