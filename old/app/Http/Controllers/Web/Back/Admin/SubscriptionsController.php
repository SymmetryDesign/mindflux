<?php

namespace App\Http\Controllers\Web\Back\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SubscriptionsController extends Controller
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
     * Get a listing of all subscriptions.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('back/admin/subscriptions/index', [
            'subscriptions' => Subscription::with(['tenant', 'plan'])->latest()->paginate(15)->transform(function ($subscription) {
                return [
                    'id'          => $subscription->id,
                    'external_id' => $subscription->external_id,
                    'customer'    => $subscription->tenant->name,
                    'plan'        => $subscription->plan->name,
                    'status'      => $subscription->status,
                    'trial_end'   => optional($subscription->trial_ends_at)->format('Y-m-d'),
                    'ends_at'     => optional($subscription->ends_at)->format('Y-m-d'),
                ];
            })
        ]);
    }

    /**
     * Show the specified subscription.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        return response()->json(
            Subscription::findOrFail($request->subscription)->asGatewaySubscription()
        );
    }
}
