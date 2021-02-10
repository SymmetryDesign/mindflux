<?php

namespace App\Http\Controllers\Web\Back\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PlansController extends Controller
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
     * Show a listing of all plans.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('back/admin/plans/index', [
            'plans' => Plan::orderBy('name')->get()->transform(function ($plan) {
                return [
                    'id'            => $plan->id,
                    'name'          => $plan->name,
                    'price'         => $plan->price,
                    'status'        => $plan->status,
                    'is_featured'   => $plan->is_featured,
                    'subscriptions' => $plan->subscriptions()->active()->count(),
                ];
            }),
        ]);
    }

    /**
     * Show create new plan page.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('back/admin/plans/create');
    }

    /**
     * Show edit plan page.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Inertia\Response
     */
    public function edit(Request $request)
    {
        return Inertia::render('back/admin/plans/edit', [
            'plan' => Plan::findOrFail($request->plan)
        ]);
    }

    /**
     * Store a newly created plan.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'                  => ['required', 'max:255'],
            'plan_id'               => ['required', 'max:255'],
            'price'                 => ['required', 'numeric'],
            'trial_days'            => ['nullable', 'numeric'],
            'disk_space'            => ['nullable', 'numeric'],
            'max_projects'          => ['nullable', 'numeric'],
            'max_users_per_project' => ['nullable', 'numeric'],
        ]);

        Plan::create([
            'external_id'           => $request->input('plan_id'),
            'name'                  => $request->input('name'),
            'description'           => $request->input('description'),
            'price'                 => $request->input('price'),
            'max_projects'          => $request->input('max_projects'),
            'max_users_per_project' => $request->input('max_users_per_project'),
            'disk_space'            => $request->input('disk_space'),
            'status'                => $request->input('status'),
            'trial_days'            => $request->input('trial_days'),
            'is_featured'           => $request->input('is_featured'),
            'is_default'            => false,
        ]);

        session()->flash('message', __('app.messages.plan-created'));

        return redirect()->route('admin:plans.index');
    }

    /**
     * Update the specified plan.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name'                  => ['required'],
            'plan_id'               => $request->plan != 1 ? ['required'] : [],
            'price'                 => ['required', 'numeric'],
            'trial_days'            => ['nullable', 'numeric'],
            'disk_space'            => ['nullable', 'numeric'],
            'max_projects'          => ['nullable', 'numeric'],
            'max_users_per_project' => ['nullable', 'numeric'],
        ]);

        $plan = Plan::findOrFail($request->plan);

        $plan->update([
            'external_id'           => $request->input('plan_id'),
            'name'                  => $request->input('name'),
            'description'           => $request->input('description'),
            'price'                 => $request->input('price'),
            'max_projects'          => $request->input('max_projects'),
            'max_users_per_project' => $request->input('max_users_per_project'),
            'disk_space'            => $request->input('disk_space'),
            'status'                => $request->input('status'),
            'trial_days'            => $request->input('trial_days'),
            'is_featured'           => $request->input('is_featured'),
        ]);

        session()->flash('message', __('app.messages.plan-updated'));

        return redirect()->route('admin:plans.index');
    }
}
