<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Requirement::class, function (Faker $faker) {
    $projects = \App\Project::all()->pluck('id')->toArray();

    return [
        'type' => $faker->randomElement(['Functional', 'Non-Functional']),
        'requirement' => $faker->sentence(),
        'project_id' => $faker->randomElement($projects)
    ];
});
