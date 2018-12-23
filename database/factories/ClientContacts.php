<?php

use App\Models\Client;
use App\Models\ClientContacts;
use Faker\Generator as Faker;

$factory->define(ClientContacts::class, function (Faker $faker) {
    return [
        'address' => $faker->address,
        'post_code' => $faker->postcode,
        'client_id' => Client::inRandomOrder()->first()->id,
    ];
});
