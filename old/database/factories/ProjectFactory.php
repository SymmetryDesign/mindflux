<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Project;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'name'        => ucwords($faker->words(2, true)),
        'description' => $faker->sentence(5, true),
        'visibility'  => Project::VISIBILITY_TEAM_MEMBERS,
        'uuid'        => Str::uuid(),
        'color'       => $faker->randomElement([
            'red', 'indigo', 'green', 'pink', 'purple', 'orange',
        ])
    ];
});

$factory->state(Project::class, 'ongoing', function (Faker $faker) {
    return [
        'start_date' => $faker->dateTimeBetween('last week', 'next week'),
        'end_date'   => $faker->dateTimeBetween('next month', 'next month +60 days'),
    ];
});

$factory->state(Project::class, 'overdue', function (Faker $faker) {
    return [
        'start_date' => $faker->dateTimeBetween('last month -2 months', 'last month -1 month'),
        'end_date'   => $faker->dateTimeBetween('last month', 'last day'),
    ];
});

$factory->state(Project::class, 'completed', [
    'completed_at' => now(),
]);

$factory->state(Project::class, 'archived', [
    'deleted_at' => now(),
]);
