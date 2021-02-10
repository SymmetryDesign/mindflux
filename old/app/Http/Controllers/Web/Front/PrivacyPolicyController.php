<?php

namespace App\Http\Controllers\Web\Front;

use App\Http\Controllers\Controller;

class PrivacyPolicyController extends Controller
{
    /**
     * Show privacy policy page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('front.privacy-policy');
    }
}
