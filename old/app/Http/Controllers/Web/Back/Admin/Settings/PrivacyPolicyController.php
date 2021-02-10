<?php

namespace App\Http\Controllers\Web\Back\Admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PrivacyPolicyController extends Controller
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
     * Show edit privacy policy page.
     *
     * @return \Inertia\Response
     */
    public function edit()
    {
        return Inertia::render('back/admin/settings/privacy-policy/index', [
            'privacy_policy' => settings('privacy_policy.content'),
            'published'      => settings('privacy_policy.published'),
        ]);
    }

    /**
     * Update privacy policy.
     *
     * @param Request $request
     * @return \Illuminate\Http\Request
     */
    public function update(Request $request)
    {
        settings([
            'privacy_policy.content'   => $request->input('content'),
            'privacy_policy.published' => $request->input('published'),
        ]);

        session()->flash('message', __('app.messages.privacy-policy-updated'));

        return back();
    }
}
