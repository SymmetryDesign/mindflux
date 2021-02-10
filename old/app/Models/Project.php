<?php

namespace App\Models;

use App\Events\Project\ProjectStatusChanged;
use App\Filters\Filterable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Project extends Model
{
    use SoftDeletes, Filterable, MultiTenantable;

    /**
     * Indicates that the project is visible to only to the creator.
     *
     * @var int
     */
    const VISIBILITY_ONLY_ME = 1;

    /**
     * Indicates that the project is visible to assigned team members.
     *
     * @var int
     */
    const VISIBILITY_TEAM_MEMBERS = 2;

    /**
     * Indicates that the project is visible to all users within the organization.
     *
     * @var int
     */
    const VISIBILITY_ORGANIZATION = 3;

    /**
     * The attributes that are mutable to dates.
     *
     * @var array
     */
    protected $dates = [
        'start_date', 'end_date', 'completed_at',
    ];

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($project) {
            $project->uuid = Str::uuid();
        });
    }

    /**
     * Get project status identifier.
     *
     * @return string
     */
    public function getStatusAttribute()
    {
        if ($this->isOngoing()) {
            return 'ongoing';
        }

        if ($this->isOverdue()) {
            return 'overdue';
        }

        if ($this->isCompleted()) {
            return 'completed';
        }

        if ($this->trashed()) {
            return 'archived';
        }
    }

    /**
     * Get project days left attribute.
     *
     * @return int|null
     */
    public function getDaysLeftAttribute()
    {
        if ($this->end_date && !$this->isCompleted() && !$this->trashed()) {
            return Carbon::now()->diffInDays($this->end_date, false);
        }
    }

    /**
     * Represent the project deadline in the following format
     * YYYY-MM-DD to YYYY-MM-DD
     *
     * @return string
     */
    public function getTimelineAttribute()
    {
        if ($this->start_date && $this->end_date) {
            return $this->start_date->toDateString() . ' to ' . $this->end_date->toDateString();
        }
    }

    /**
     * Filter ongoing projects.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return void
     */
    public function scopeOngoing($query)
    {
        $query->where('end_date', '>=', now())
            ->orWhere('end_date', null)
            ->whereNull('completed_at')
            ->whereNull('deleted_at');
    }

    /**
     * Filter overdue projects.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return void
     */
    public function scopeOverdue($query)
    {
        $query->where('end_date', '<', now())
            ->whereNull('completed_at')
            ->whereNull('deleted_at');
    }

    /**
     * Filter completed projects.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return void
     */
    public function scopeCompleted($query)
    {
        $query->whereNotNull('completed_at')
            ->whereNull('deleted_at');
    }

    /**
     * Filter archived projects.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return void
     */
    public function scopeArchived($query)
    {
        $query->onlyTrashed();
    }

    /**
     * Filter accessible projects by the authenticated user.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeAccessible($query)
    {
        if (auth()->user()->role === User::ROLE_TENANT_OWNER) {
            return;
        }

        $query->where('visibility', Project::VISIBILITY_ORGANIZATION)
            ->orWhere('user_id', auth()->user()->id)
            ->orWhereHas('teamMembers', function ($q) {
                return $q->where('id', auth()->user()->id);
            });
    }

    /**
     * The project is created by a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The project is assigned to many team members.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teamMembers()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * The project has many columns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function columns()
    {
        return $this->hasMany(Column::class);
    }

    /**
     * The project has many tasks.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function tasks()
    {
        return $this->hasManyThrough(Task::class, Column::class);
    }

    /**
     * The project belongs to a tenant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * The project is watched by many users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function watchers()
    {
        return $this->belongsToMany(User::class, 'project_watcher');
    }

    /**
     * Determine if the project is ongonig.
     *
     * @return bool
     */
    public function isOngoing()
    {
        return (optional($this->end_date)->isFuture() || $this->end_date === null) &&
            $this->completed_at === null &&
            !$this->trashed();
    }

    /**
     * Determine if the project is overdue.
     *
     * @return bool
     */
    public function isOverdue()
    {
        return $this->end_date !== null &&
            optional($this->end_date)->isPast() &&
            $this->completed_at === null &&
            !$this->trashed();
    }

    /**
     * Determine if the project is completed.
     *
     * @return bool
     */
    public function isCompleted()
    {
        return $this->completed_at !== null && !$this->trashed();
    }

    /**
     * Determine if the project is favorited by the user.
     *
     * @return bool
     */
    public function isFavorite()
    {
        return auth()->user()->favoriteProjects->contains(function ($project) {
            return $project->id === $this->id;
        });
    }

    /**
     * Determine if the project is accessible by authenticated user.
     *
     * @return bool
     */
    public function isAccessible()
    {
        if (auth()->user()->id === $this->user_id || $this->visibility === Project::VISIBILITY_ORGANIZATION) {
            return true;
        }

        return $this->teamMembers->contains(auth()->user()->id);
    }

    /**
     * Determine if the project is watched by the current authenticated user or by the specified user.
     *
     * @param null $user
     * @return bool
     */
    public function isWatched($user = null)
    {
        if ($user === null) {
            $user = auth()->user();
        }

        return $this->watchers()
            ->where('user_id', $user->id)
            ->exists();
    }

    /**
     * Mark the project as completed.
     *
     * @return void
     */
    public function markAsCompleted()
    {
        $this->fill([
            'completed_at' => now(),
        ])->save();

        event(new ProjectStatusChanged($this));
    }

    /**
     * Mark the project as incomplete.
     *
     * @return void
     */
    public function markAsIncomplete()
    {
        $this->fill([
            'completed_at' => null,
        ])->save();

        event(new ProjectStatusChanged($this));
    }
}
