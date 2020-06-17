<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Admin;
use App\Models\AdminGroups;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Admin::class, function (Faker $faker) {

    return [
        'name'          => $faker->unique()->name,
        'email'         => $faker->unique()->email,
        'password'      => 'password',
        'birthday'      => $faker->unixTime,
        'gender'        => rand(1,3),
        'post_code'     => $faker->postcode,
        'city_name'     => $faker->city,
        'address'       => $faker->address,
        'tel'           => $faker->phoneNumber,
        'created_by'    => 'seeder'
    ];
});
