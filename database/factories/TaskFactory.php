<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Task;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'uuid'     => Str::uuid(),
        'content'  => $faker->sentence,
        'due_date' => $faker->randomElement([
            null, $faker->dateTimeBetween('this month', 'next month +2 days')
        ])
    ];
});

$factory->state(Task::class, 'completed', [
    'completed_at' => now(),
]);

$factory->state(Task::class, 'incompleted', [
    'completed_at' => null,
]);
