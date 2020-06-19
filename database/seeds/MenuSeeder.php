<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = collect([
            ['menu_parent' => 0,'menu' => 'Master','uri' => 'master'],
            ['menu_parent' => 1,'menu' => 'Menu','uri' => 'menu'],
            ['menu_parent' => 1,'menu' => 'Permission','uri' => 'permission'],
            ['menu_parent' => 1,'menu' => 'Role','uri' => 'role'],
            ['menu_parent' => 1,'menu' => 'User','uri' => 'user'],
        ])->mapWithKeys(function ($imenu) {
            return factory(App\Menu::class)->create([
                'menu_parent' => $imenu['menu_parent'],
                'menu_name' => $imenu['menu'],
                'menu_uri' => $imenu['uri']
            ]);
        });
    }
}
