<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name'              => $faker->name,
        'email'             => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password'          => bcrypt('secret'),
        'remember_token'    => Str::random(10),
    ];
});

$factory->state(User::class, 'admin', [
    'role' => User::ROLE_ADMIN,
]);

$factory->state(User::class, 'tenant_owner', [
    'role'         => User::ROLE_TENANT_OWNER,
    'tenant_owner' => true,
]);

$factory->state(User::class, 'tenant_user', [
    'role' => User::ROLE_TENANT_USER,
]);
