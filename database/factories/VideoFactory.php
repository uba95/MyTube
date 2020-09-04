<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Channel;
use App\Video;
use Faker\Generator as Faker;

$factory->define(Video::class, function (Faker $faker) {
    return [
        
        'channel_id' => factory(Channel::class),
        'views' => $faker->numberBetween(0, 3000),
        'thumbnail' => $faker->imageUrl(),
        'percentage' => 100,
        'title' => $faker->sentence(rand(2,6)),
        'description' => $faker->paragraph(rand(1,5)),
        'path' => $faker->word(),

    ];
});
