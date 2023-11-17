<?php

use Spatie\Permission\Models\Permission;

function modulesList(){
   return [
    [ 'id' => 1,'slug' => 'dashboard'],
    [ 'id' => 2,'slug' => 'users'],
    [ 'id' => 3,'slug' => 'roles'],
    [ 'id' => 4,'slug' => 'customers'],
];}


function runTimeChecked($myId, $matchId)
{
    if ($myId == $matchId)
        return 'checked';
}

function autoCreatePermissionUsingModules()
{
    foreach (modulesList() as $module) {
        Permission::UpdateOrCreate(['name' => $module['slug'] . '-view']);
        Permission::UpdateOrCreate(['name' => $module['slug'] . '-create']);
        Permission::UpdateOrCreate(['name' => $module['slug'] . '-edit']);
        Permission::UpdateOrCreate(['name' => $module['slug'] . '-delete']);
        Permission::UpdateOrCreate(['name' => $module['slug'] . '-status']);
    }
}

