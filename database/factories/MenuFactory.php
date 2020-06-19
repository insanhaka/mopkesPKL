<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Menu;
use Faker\Generator as Faker;

$factory->define(Menu::class, function (Faker $faker) {
    return [
        'menu_parent' => 'parent',
        'menu_name' => 'menu',
        'menu_uri' => 'uri',
        'menu_group' => 4,
        'menu_active' => true,
        'created_by' => 'myself',
    ];
});
