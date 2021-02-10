<?php

namespace App\Http\Controllers\Web\Front;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Models\Plan;

class HomeController extends Controller
{
    /**
     * Show homepage.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('front.index', [
            'plans'    => Plan::active()->get(),
            'features' => Feature::all(),
        ]);
    }
}
