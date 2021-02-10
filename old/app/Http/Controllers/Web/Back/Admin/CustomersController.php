<?php

namespace App\Http\Controllers\Web\Back\Admin;

use App\Filters\TenantFilter;
use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomersController extends Controller
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
     * Show a listing of all customers.
     *
     * @param TenantFilter $filters
     * @return \Inertia\Response
     */
    public function index(TenantFilter $filters)
    {
        return Inertia::render('back/admin/customers/index', [
            'filters' => request()->all('status', 'search'),
            'tenants' => Tenant::filter($filters)->latest()->paginate()->transform(function ($tenant) {
                return [
                    'id'               => $tenant->id,
                    'name'             => $tenant->name,
                    'email'            => $tenant->owner()->email,
                    'registered_since' => $tenant->created_at->diffForHumans(),
                    'status'           => $tenant->status,
                ];
            })
        ]);
    }

    /**
     * Show a specific customer page.
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function show(Request $request)
    {
        $tenant = Tenant::findOrFail($request->customer);

        return Inertia::render('back/admin/customers/show', [
            'tenant' => [
                'id'               => $tenant->id,
                'name'             => $tenant->name,
                'status'           => $tenant->status,
                'email'            => $tenant->owner()->email,
                'registered_since' => $tenant->created_at->diffForHumans(),
                'projects'         => $tenant->projects->count(),
                'disk_usage'       => $tenant->diskSpaceUsage(),
                'team_members'     => $tenant->users->count(),
                'billing'          => [
                    'name'          => $tenant->name,
                    'address_line1' => $tenant->address_line1,
                    'address_line2' => $tenant->address_line2,
                    'city'          => $tenant->city,
                    'country'       => $tenant->country,
                    'postal_code'   => $tenant->postal_code,
                    'state'         => $tenant->state,
                    'phone'         => $tenant->phone,
                ],
                'subscriptions'    => $tenant->subscriptions->transform(function ($subscription) {
                    return [
                        'plan'          => $subscription->plan->name,
                        'trial_ends_at' => optional($subscription->trial_ends_at)->format('Y-m-d'),
                        'ends_at'       => optional($subscription->ends_at)->format('Y-m-d'),
                        'status'        => $subscription->status,
                    ];
                }),
            ]
        ]);
    }
}
