<?php

namespace App\Http\Controllers\Web\Front\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Inertia\Inertia;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Show reset password page.
     *
     * @return \Inertia\Response
     */
    public function show()
    {
        return Inertia::render('front/auth/passwords/reset', [
            'token' => request()->query('token'),
            'email' => request()->email,
        ]);
    }
}
