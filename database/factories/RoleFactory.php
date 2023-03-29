<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2/09/2018
 * Time: 12:37 PM
 */

$factory->define(App\Models\Role::class, function () {
    return [
        'name' => 'Super Administrador',
        'superadmin' => true
    ];
});