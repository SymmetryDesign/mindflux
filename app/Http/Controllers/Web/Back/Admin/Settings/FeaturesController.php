<?php

namespace App\Http\Controllers\Web\Back\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;

class FeaturesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Store a newly created feature.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
        ]);

        Feature::create([
            'title'       => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        session()->flash('message', __('app.messages.feature-added'));

        return back();
    }

    /**
     * Update the specified feature.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'title'       => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);

        Feature::findOrFail($request->feature)->update([
            'title'       => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        session()->flash('message', __('app.messages.featured-updated'));

        return back();
    }

    /**
     * Delete the specified feature.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $feature = Feature::findOrFail($request->feature);

        $feature->delete();

        session()->flash('message', __('app.messages.feature-deleted'));

        return back();
    }
}
