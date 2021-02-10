<?php

namespace App\Models;

use App\Filters\Filterable;
use Billing;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Plank\Mediable\Media;

class Tenant extends Model
{
    use SoftDeletes, Filterable;

    /**
     * The attributes that are appended with this model.
     *
     * @var array
     */
    protected $appends = [
        'status',
    ];

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tenant) {
            $tenant->uuid = Str::uuid();
        });
    }

    /**
     * Get tenant status based on subscriptions.
     *
     * @return string
     */
    public function getStatusAttribute()
    {
        if ($this->hasActiveSubscription()) {
            return 'active';
        }

        if ($this->subscriptions()->active()->count() ||
            $this->subscriptions()->canceled()->count()) {
            return 'previous';
        }
    }

    /**
     * The tenant has many users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * The tenant has many subscriptions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * The tenant has many projects.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    /**
     * The tenant has many uplaoded files.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function media()
    {
        return $this->hasMany(Media::class);
    }

    /**
     * Retrieve the owner of this tenant.
     *
     * @return \App\Models\User
     */
    public function owner()
    {
        return $this->users->where('role', User::ROLE_TENANT_OWNER)
            ->where('tenant_owner', true)
            ->first();
    }

    /**
     * Determine if the tenant is registered as customer.
     *
     * @return bool
     */
    public function registeredAsCustomer()
    {
        return $this->customer_id !== null;
    }

    /**
     * Generate client secret.
     *
     * @return string
     */
    public function generateClientToken()
    {
        return Billing::generateClientToken($this);
    }

    /**
     * Get customer payment methods.
     *
     * @return mixed
     */
    public function paymentMethods()
    {
        return Billing::getPaymentMethods($this);
    }

    /**
     * Add payment method to the customer.
     *
     * @param string $paymentMethod
     * @return void
     */
    public function addPaymentMethod($paymentMethod)
    {
        Billing::addPaymentMethod($this, $paymentMethod);
    }

    /**
     * Set default payment method.
     *
     * @param $paymentMethod
     * @return void
     */
    public function setDefaultPaymentMethod($paymentMethod)
    {
        Billing::setDefaultPaymentMethod($this, $paymentMethod);
    }

    /**
     * Remove payment method from the customer.
     *
     * @param string $paymentMethod
     * @return void
     */
    public function deletePaymentMethod($paymentMethod)
    {
        Billing::deletePaymentMethod($this, $paymentMethod);
    }

    /**
     * Get default active subscription.
     *
     * @return \App\Models\Subscription
     */
    public function defaultSubscription()
    {
        return $this->subscriptions->sortByDesc(function ($subscription) {
            return $subscription->created_at->getTimestamp();
        })->first();
    }

    /**
     * Determine if the customer have active subscription.
     *
     * @return bool
     */
    public function hasActiveSubscription()
    {
        return $this->defaultSubscription() && $this->defaultSubscription()->valid();
    }

    /**
     * Create a new subscription for the customer.
     *
     * @param \App\Models\Plan $plan
     * @return \App\Models\Subscription
     */
    public function subscribe($plan)
    {
        return Billing::createSubscription($this, $plan);
    }

    /**
     * Create tenant as customer in billing service provider.
     *
     * @return \App\Models\Tenant
     */
    public function createAsCustomer()
    {
        return Billing::createCustomer($this);
    }

    /**
     * Update tenant in billing service provider.
     *
     * @return \App\Models\Tenant
     */
    public function updateCustomer()
    {
        return Billing::updateCustomer($this);
    }

    /**
     * Determine if the tenant has exceeded current plan limits.
     *
     * @return bool
     */
    public function exceededPlanLimits()
    {
        return $this->exceededMaxProjectsLimit() ||
            $this->exceededMaxUsersPerProjectLimit() ||
            $this->exceededDiskSpaceLimit();
    }

    /**
     * Determine if the tenant has exceeded max projects limit.
     *
     * @return bool
     */
    public function exceededMaxProjectsLimit()
    {
        if ($this->hasActiveSubscription()) {
            return $this->defaultSubscription()->plan->max_projects !== null &&
                $this->projects->count() > $this->defaultSubscription()->plan->max_projects;
        }

        if (!$this->hasActiveSubscription() && Plan::freeEnabled()) {
            return Plan::free()->max_projects !== null &&
                $this->projects->count() > Plan::free()->max_projects;
        }

        return true;
    }

    /**
     * Determine if the tenant has exceeded max users per project limit.
     *
     * @return bool
     */
    public function exceededMaxUsersPerProjectLimit()
    {
        if ($this->hasActiveSubscription()) {
            return $this->projects->each->teamMembers->contains(function ($project) {
                return $this->defaultSubscription()->plan->max_users_per_project !== null &&
                    $project->teamMembers->count() > $this->defaultSubscription()->plan->max_users_per_project;
            });
        }

        if (!$this->hasActiveSubscription() && Plan::freeEnabled()) {
            return $this->projects->each->teamMembers->contains(function ($project) {
                return Plan::free()->max_users_per_project !== null &&
                    $project->teamMembers->count() > Plan::free()->max_users_per_project;
            });
        }

        return true;
    }

    /**
     * Determine if the tenant has exceeded the disk space limit.
     *
     * @return bool
     */
    public function exceededDiskSpaceLimit()
    {
        if ($this->hasActiveSubscription()) {
            return $this->defaultSubscription()->plan->disk_space !== null &&
                $this->diskSpaceUsage() > $this->defaultSubscription()->plan->disk_space;
        }

        if (!$this->hasActiveSubscription() && Plan::freeEnabled()) {
            return Plan::free()->disk_space !== null &&
                $this->diskSpaceUsage() > Plan::free()->disk_space;
        }

        return true;
    }

    /**
     * Calculate tenant's disk space usage in MB.
     *
     * @return float
     */
    public function diskSpaceUsage()
    {
        return bytes_to_mb($this->media->sum('size'));
    }
}
