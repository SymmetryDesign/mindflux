<?php

namespace App\Http\Controllers\Web\Back\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Inertia\Inertia;

class LandingPageSettingsController extends Controller
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
     * Show edit landing settings page.
     *
     * @return \Inertia\Response
     */
    public function edit()
    {
        return Inertia::render('back/admin/settings/landing-page/index', [
            'hero'     => [
                'heading'    => settings('hero.heading'),
                'subheading' => settings('hero.subheading'),
            ],
            'pricing'  => [
                'heading'    => settings('pricing.heading'),
                'subheading' => settings('pricing.subheading'),
            ],
            'features' => [
                'data'       => Feature::all(),
                'heading'    => settings('features.heading'),
                'subheading' => settings('features.subheading'),
            ]
        ]);
    }
}
