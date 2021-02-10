<?php

namespace App\Http\Controllers\Web\Back\App\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PasswordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('tenant.user');
    }

    /**
     * Show edit password page.
     *
     * @return \Inertia\Response
     */
    public function edit()
    {
        return Inertia::render('back/app/account/password/edit');
    }

    /**
     * Update user password.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'password' => ['required', 'string', 'confirmed', 'max:255'],
        ]);

        auth()->user()->update([
            'password' => bcrypt($request->input('password')),
        ]);

        session()->flash('message', __('app.messages.password-changed'));

        return back();
    }
}
