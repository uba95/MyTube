<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Channel;
use App\Subscription;
use App\User;
use Faker\Generator as Faker;

$factory->define(Subscription::class, function (Faker $faker) {
    return [
        
        'user_id' => factory(User::class),
        'channel_id' => factory(Channel::class),
    ];
});
