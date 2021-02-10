<?php

namespace App\Http\Controllers\Web\Front;

use App\Http\Controllers\Controller;

class TermsAndConditionsController extends Controller
{
    /**
     * Show terms and conditions page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('front.terms-and-conditions');
    }
}
