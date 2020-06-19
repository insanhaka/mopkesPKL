<?php

use Illuminate\Database\Seeder;

class PermissionroleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = App\Permission::all();
        App\Role::all()->each(function ($role) use ($permissions) { 
            $role->permissions()->attach(
                $permissions->pluck('id')->toArray()
            ); 
        });

    }
}
