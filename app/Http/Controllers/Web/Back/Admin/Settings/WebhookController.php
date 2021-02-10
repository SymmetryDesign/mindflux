<?php

namespace App\Http\Controllers\Web\Back\Admin\Settings;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class WebhookController extends Controller
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
     * Show webhook settings page.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('back/admin/settings/webhook/index', [
            'url' => route('webhook.handler', settings('webhook.secret')),
        ]);
    }
}
