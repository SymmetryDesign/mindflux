<?php

namespace App\Http\Controllers\Web\Back\Admin\Account;

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
        $this->middleware('admin');
    }

    /**
     * Show edit password page.
     *
     * @return \Inertia\Response
     */
    public function edit()
    {
        return Inertia::render('back/admin/account/password/edit');
    }

    /**
     * Change user password.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'password' => ['required', 'string', 'confirmed'],
        ]);

        auth()->user()->update([
            'password' => bcrypt($request->input('password')),
        ]);

        session()->flash('message', __('app.messages.password-changed'));

        return back();
    }
}
