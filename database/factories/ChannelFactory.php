<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Channel;
use Faker\Generator as Faker;

$factory->define(Channel::class, function (Faker $faker) {
    return [
        
        'name' => $faker->name(),
        'user_id' => factory(App\User::class),
        'description' => $faker->sentences(rand(1, 5), true),
    ];
});
