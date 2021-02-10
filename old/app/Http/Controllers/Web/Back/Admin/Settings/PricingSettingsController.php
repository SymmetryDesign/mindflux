<?php

namespace App\Http\Controllers\Web\Back\Admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PricingSettingsController extends Controller
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
     * Update landing page settings.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'pricing_heading'    => ['required', 'string'],
            'pricing_subheading' => ['required', 'string'],
        ]);

        settings([
            'pricing.heading'    => $request->input('pricing_heading'),
            'pricing.subheading' => $request->input('pricing_subheading'),
        ]);

        session()->flash('message', __('app.messages.settings-updated'));

        return back();
    }
}
