<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use App\Video;
use App\User;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [

        'user_id' => factory(User::class),
        'video_id' => factory(Video::class),
        'body' => $faker->paragraph(rand(2,3)),
    ];
});
