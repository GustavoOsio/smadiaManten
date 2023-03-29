<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [];
        foreach (\App\Models\Role::all() as $role) {
            $roles[] = $role->id;
        }
        App\Models\Menu::all()->each(function ($menu) use ($roles) {
            $menu->roles()->attach($roles);
        });
    }
}