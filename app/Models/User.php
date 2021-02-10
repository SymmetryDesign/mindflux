<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Plank\Mediable\Mediable;

class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Notifiable, Authenticatable, Authorizable, HasPreference,
        CanResetPassword, SoftDeletes, MultiTenantable, Mediable;

    /**
     * Indicates that this user is a business owner.
     *
     * @var int
     */
    const ROLE_ADMIN = 1;

    /**
     * Indicates that this user is a tenant owner.
     *
     * @var int
     */
    const ROLE_TENANT_OWNER = 2;

    /**
     * Indicates that this user is a tenant user.
     *
     * @var int
     */
    const ROLE_TENANT_USER = 3;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'avatar_url',
    ];

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->uuid = Str::uuid();
        });
    }

    /**
     * Get user avatar URL.
     *
     * @return string
     */
    public function getAvatarUrlAttribute()
    {
        $avatar = $this->getMedia('avatars')->last();

        if ($avatar) {
            return $avatar->getUrl();
        }

        return url('imgs/avatar.jpg');
    }

    /**
     * The user belongs to a tenant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * The user is assigned to many projects.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function assignedProjects()
    {
        return $this->belongsToMany(Project::class);
    }

    /**
     * The user has many favorite projects.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function favoriteProjects()
    {
        return $this->belongsToMany(Project::class, 'favorite_project_user');
    }

    /**
     * The user has many tasks.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * The user watches many projects.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function watchedProjects()
    {
        return $this->belongsToMany(Project::class, 'project_watcher');
    }

    /**
     * Check if the user is business owner.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === User::ROLE_ADMIN;
    }

    /**
     * Determine if the user is tenant owner.
     *
     * @return bool
     */
    public function isTenantOwner()
    {
        return $this->role === User::ROLE_TENANT_OWNER;
    }

    /**
     * Determine if the user is tenant user.
     *
     * @return bool
     */
    public function isTenantUser()
    {
        return $this->role === User::ROLE_TENANT_USER;
    }

    /**
     * Get cache key for the user.
     *
     * @param $key
     * @return string
     */
    public function cacheKey($key)
    {
        return auth()->user()->uuid . '.' . $key;
    }
}
