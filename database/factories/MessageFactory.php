<?php

use Faker\Generator as Faker;

$factory->define(App\Message::class, function (Faker $faker) {
    return [
        //
        'message' => $faker->realText($maxNbChars = 100, $indexSize = 2),
    ];
});
