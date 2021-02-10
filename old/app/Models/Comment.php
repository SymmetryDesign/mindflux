<?php

namespace App\Models;

use Illuminate\Support\Str;
use Plank\Mediable\Mediable;

class Comment extends Model
{
    use Mediable;

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($comment) {
            $comment->uuid = Str::uuid();
        });
    }

    /**
     * The comment belongs to a task.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * The comment belongs to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
