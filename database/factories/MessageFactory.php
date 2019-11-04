<?php

use Faker\Generator as Faker;

$factory->define(App\Message::class, function (Faker $faker) {
    return [
        'sender'=>$faker->randomElement([11711106,11709456]),
        'message'=>$faker->sentence(30),
        'chat_id'=>1,
    ];
});
