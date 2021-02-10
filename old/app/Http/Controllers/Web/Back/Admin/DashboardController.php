<?php

namespace App\Http\Controllers\Web\Back\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\Tenant;
use Inertia\Inertia;

class DashboardController extends Controller
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
     * Show business owner dashboard page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return Inertia::render('back/admin/dashboard', [
            'customers_by_month' => $this->customersByMonth(),
            'stats'              => $this->stats(),
        ]);
    }

    /**
     * Get new customers by month.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function customersByMonth()
    {
        $months = collect()->pad(12, 0);

        Tenant::whereYear('created_at', date('Y'))
            ->get()
            ->groupBy(function ($tenant) {
                return $tenant->created_at->format('m');
            })
            ->map
            ->count()
            ->each(function ($value, $key) use ($months) {
                $months->put(intval($key) - 1, $value);
            });

        return $months;
    }

    /**
     * Get dashboard stats numbers.
     *
     * @return array
     */
    protected function stats()
    {
        return [
            'active_subscriptions'     => Subscription::active()->count(),
            'incomplete_subscriptions' => Subscription::incomplete()->count(),
            'total_customers'          => Tenant::count(),
            'new_customers'            => Tenant::whereBetween('created_at', [
                now()->startOfMonth(), now()->endOfMonth()
            ])->count(),
        ];
    }
}
