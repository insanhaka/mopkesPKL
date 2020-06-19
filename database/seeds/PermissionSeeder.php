<?php

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Menu::all()->each(function ($menu){
            if($menu->menu_uri != 'master'){
                $access = collect([
                    ['access' => 'active'],
                    ['access' => 'create'],
                    ['access' => 'edit'],
                    ['access' => 'delete'],
                ]);
            }else{
                $access = collect([
                    ['access' => 'active'],
                ]);
            }
            $access->mapWithKeys(function ($iaccess) use ($menu) {
                return factory(App\Permission::class)->create([
                    'menu_id' => $menu->id,
                    'permission_name' => $menu->menu_uri.'-'.$iaccess['access'],
                    'permission_description' => 'Allow Access '.$menu->menu.' '.ucfirst($iaccess['access'])
                ]);
            });
        });
    }
}
