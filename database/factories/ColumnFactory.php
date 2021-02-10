<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Column;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Column::class, function (Faker $faker) {
    return [
        'name' => $faker->words(2, true),
        'uuid' => Str::uuid()
    ];
});
