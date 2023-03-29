<?php

namespace App\Helpers;

use App\Models\Menu;

class MenuRol {

    public static function permissions($menu_id, $action) {
        $array = [];
        $permissions = Menu::find($menu_id)->roles()->where('menu_role.' . $action, 1)->get();
        foreach ($permissions as $per) {
            $array[] = $per->id;
        }
        return $array;
    }

}