<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Project::class, function (Faker $faker) {
    $users = \App\User::all()->pluck('username')->toArray();

    return [
        'name' => $faker->unique()->bs,
        'description' => $faker->sentence(),
        'created_by' => $faker->randomElement($users),
        'updated_by' => $faker->randomElement($users),
        'last_process' => $faker->randomElement(['BUSINESS_GOALS', 'CBP', 'FIND_PATTERN', 'FBP', 'REQ_DEF', 'ACCEPTANCE', 'COMPLETED'])
    ];
});
