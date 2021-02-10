<?php

namespace App\Http\Controllers\Web\Back\App\Projects;

use App\Http\Controllers\Controller;
use App\Models\Column;
use Illuminate\Http\Request;

class ProjectColumnsSortController extends Controller
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
     * Update the sort of the columns.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request)
    {
        collect($request->input('columns'))->each(function ($column, $index) {
            $column = Column::where('uuid', $column)->firstOrFail();

            $this->authorize('update', $column);

            $column->update([
                'index' => $index
            ]);
        });

        return back();
    }
}
