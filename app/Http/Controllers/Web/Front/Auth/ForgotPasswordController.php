<?php

namespace App\Http\Controllers\Web\Front\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * Show forgot password page.
     *
     * @return \Inertia\Response
     */
    public function show()
    {
        return Inertia::render('front/auth/passwords/email');
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $response
     * @return \Illuminate\Http\Response
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        session()->flash('message', trans($response));

        return back();
    }
}
