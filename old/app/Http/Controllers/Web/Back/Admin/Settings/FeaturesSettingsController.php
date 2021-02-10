<?php

namespace App\Http\Controllers\Web\Back\Admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeaturesSettingsController extends Controller
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
     * Update features settings.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'features_heading'    => ['required', 'string'],
            'features_subheading' => ['required', 'string'],
        ]);

        settings([
            'features.heading'    => $request->input('features_heading'),
            'features.subheading' => $request->input('features_subheading'),
        ]);

        session()->flash('message', __('app.messages.settings-updated'));

        return back();
    }
}
