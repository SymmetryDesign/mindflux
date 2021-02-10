<?php

namespace App\Http\Controllers\Web\Back\Admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomepageSettingsController extends Controller
{
    /**
     * Show edit homepage settings page.
     *
     * @return \Inertia\Response
     */
    public function edit()
    {
        return Inertia::render('back/admin/settings/homepage/index', [
            'enable' => settings('custom_homepage.enabled', false),
            'url'    => settings('custom_homepage.url'),
        ]);
    }

    /**
     * Update homepage settings.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'url' => [$request->input('enable') ? 'required' : 'nullable']
        ]);

        settings([
            'custom_homepage.enabled' => $request->input('enable'),
            'custom_homepage.url'     => $request->input('url'),
        ]);

        session()->flash('message', __('app.messages.settings-updated'));

        return redirect()->back();
    }
}
