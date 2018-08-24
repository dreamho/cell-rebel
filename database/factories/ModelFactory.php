<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use Ranking\Models\MobileOperator;
use Ranking\Models\Review;
use Ranking\Models\Scores;
use Ranking\Models\WorldCity;
use Ranking\Models\WorldCountry;
use Ranking\User;

$factory->define(MobileOperator::class, function (Faker\Generator $faker) {
    return [
        'country_code'  => $faker->countryCode,
        'name'          => $faker->company
    ];
});

$factory->define(User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(WorldCity::class, function(Faker\Generator $faker){
    return [
        'id'        => $faker->randomNumber(),
        'code'      => $faker->countryCode,
        'country'   => $faker->country,
        'name'      => $faker->city,
        'latitude'  => $faker->latitude,
        'longitude' => $faker->longitude,
        'altitude'  => $faker->randomFloat()
    ];
});

$factory->define(WorldCountry::class, function(Faker\Generator $faker){
    return [
        'ncode'             => $faker->randomNumber(),
        'code'              => $faker->countryCode,
        'name'              => $faker->country,
        'region'            => $faker->word,
        'subregion'         => $faker->word,
        'capital_city_id'   => $faker->randomNumber()
    ];
});

$factory->define(Scores::class, function(Faker\Generator $faker){
    return [
        'timeperiod'                => $faker->word,
        'country_id'                => $faker->randomDigit,
        'city_id'                   => $faker->randomDigit,
        'mobile_operator_id'        => $faker->randomDigit,
        'ux'                        => $faker->randomFloat(2, 1.0, 10.0),
        'price'                     => $faker->randomFloat(2, 1.0, 10.0),
        'web_browsing'              => $faker->randomFloat(2, 1.0, 10.0),
        'video'                     => $faker->randomFloat(2, 1.0, 10.0),
        'data_dl'                   => $faker->randomFloat(2, 1.0, 10.0),
        'data_ul'                   => $faker->randomFloat(2, 1.0, 10.0),
        'wb_avg_pgldtime'           => $faker->randomFloat(2, 1.0, 10.0),
        'wb_wrst10p_pgldtime'       => $faker->randomFloat(2, 1.0, 100.0),
        'wb_avg_failrate'           => $faker->randomFloat(2, 1.0, 10.0),
        'video_avg_starttime'       => $faker->randomFloat(2, 1.0, 10.0),
        'video_wrst10p_starttime'   => $faker->randomFloat(2, 1.0, 100.0),
        'video_avg_rebuffering'     => $faker->randomFloat(2, 1.0, 10.0),
        'video_avg_bit_rate'        => $faker->randomFloat(2, 1.0, 10.0),
        'data_dl_avg_speed'         => $faker->randomFloat(2, 1.0, 10.0),
        'data_dl_wrst10p_speed'     => $faker->randomFloat(2, 1.0, 10.0),
        'data_ud_avg_speed'         => $faker->randomFloat(2, 1.0, 10.0),
        'data_ud_wrst10p_speed'     => $faker->randomFloat(2, 1.0, 10.0),
        'score_for'                 => 'C'
   ];
});

$factory->define( Review::class, function(Faker\Generator $faker) {
    return [
        'mobile_operator_id' => $faker->numberBetween(1, 142),
        'title' => $faker->sentence,
        'details' => $faker->paragraph,
        'author' => $faker->name
    ];
});