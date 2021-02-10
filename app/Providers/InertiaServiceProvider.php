<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class InertiaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        Inertia::version(function () {
            return md5_file(public_path('mix-manifest.json'));
        });

        Inertia::share([
            'logo_light' => settings('logo.light'),

            'logo_dark' => settings('logo.dark'),

            'user' => function () {
                if (auth()->check()) {
                    return [
                        'id'         => auth()->user()->id,
                        'name'       => auth()->user()->name,
                        'email'      => auth()->user()->email,
                        'avatar_url' => auth()->user()->avatar_url,
                    ];
                }
            },

            'errors' => function () {
                if (session()->get('errors')) {
                    return session()->get('errors')->getBag('default')->getMessages();
                }

                return (object)[];
            },

            'flash' => function () {
                return session()->get('message');
            },

            'favorite_projects' => function () {
                if (auth()->check()) {
                    return auth()->user()->favoriteProjects()->withTrashed()->get()->map->only([
                        'uuid', 'name', 'color',
                    ]);
                }
            },
        ]);
    }
}
