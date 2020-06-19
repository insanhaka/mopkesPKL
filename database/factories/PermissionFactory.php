<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Permission;
use Faker\Generator as Faker;

$factory->define(Permission::class, function (Faker $faker) {
    return [
        'permission_name' => 'master-active',
        'permission_description' => 'Allow You to Access Pemission',
        'created_by' => 'myself',
    ];
});
