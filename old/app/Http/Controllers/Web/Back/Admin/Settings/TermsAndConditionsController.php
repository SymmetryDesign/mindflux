<?php

namespace App\Http\Controllers\Web\Back\Admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TermsAndConditionsController extends Controller
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
     * Show edit terms and conditions page.
     *
     * @return \Inertia\Response
     */
    public function edit()
    {
        return Inertia::render('back/admin/settings/terms-and-conditions/index', [
            'terms_and_conditions' => settings('terms_and_conditions.content'),
            'published'            => settings('terms_and_conditions.published', false)
        ]);
    }

    /**
     * Update terms and conditions.
     *
     * @param Request $request
     * @return \Illuminate\Http\Request
     */
    public function update(Request $request)
    {
        settings([
            'terms_and_conditions.published' => $request->input('published'),
            'terms_and_conditions.content'   => $request->input('content'),
        ]);

        session()->flash('message', __('app.messages.terms-and-conditions-updated'));

        return back();
    }
}
