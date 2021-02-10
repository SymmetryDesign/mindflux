<?php

namespace App\Http\Controllers\Web\Back\App\Account;

use App\Http\Controllers\Controller;
use App\Support\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class SystemPreferencesController extends Controller
{
    /**
     * Show edit system preferences page.
     *
     * @return \Inertia\Response
     */
    public function edit()
    {
        return Inertia::render('back/app/account/system-preferences/edit', [
            'languages' => Language::available(),
            'locale'    => auth()->user()->preferences()->get('locale', settings('locale', 'en')),
        ]);
    }

    /**
     * Update system preferences.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        auth()->user()->preferences()->set([
            'locale' => $request->input('locale'),
        ]);

        Cache::forget(auth()->user()->cacheKey('locale'));

        session()->flash('message', __('app.messages.system-preferences-updated'));

        return back();
    }
}
