<?php

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

$factory->define(App\User::class, function () {
    return [
        'name' => 'Super',
        'email' => 'admin@smadiaclinic.com',
        'username' => 'admin',
        'password' => 'secret', // secret
        'lastname' => 'Administrador',
        'identy' => '1111111',
        'date_expedition' => date("Y-m-d"),
        'birthday' => date("Y-m-d"),
        'state_id' => 8,
        'city_id' => 88,
        'gender_id' => 1,
        'address' => 'Cra',
        'phone' => '0000000',
        'cellphone' => '0000000000',
        'blood_id' => 1,
        'f_name' => 'Juan',
        'f_lastname' => 'Lopez',
        'f_address' => 'Cra',
        'f_phone' => '0000000',
        'f_cellphone' => '0000000000',
        'f_relationship' => 'Padre',
    ];
});
