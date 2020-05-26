<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Contributor::class, function (Faker $faker) {
    $users = \App\User::all()->pluck('id')->toArray();
    $projects = \App\Project::all()->pluck('id')->toArray();

    return [
        'user_id' => $faker->randomElement($users),
        'project_id' => $faker->randomElement($projects)
    ];
});
