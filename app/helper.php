<?php

use Spatie\Permission\Models\Permission;

function modulesList(){
   return [
    [ 'id' => 1,'slug' => 'dashboard'],
    [ 'id' => 2,'slug' => 'roles'],
    [ 'id' => 3,'slug' => 'users'],
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

function getRoles()
{
    return \Spatie\Permission\Models\Role::all();
}

function getRoleByName($name)
{
    return \Spatie\Permission\Models\Role::where('name', $name)->first();
}

function getActivities()
{
    return \Spatie\Activitylog\Models\Activity::latest()->limit(10)->get();
}

function textClass()
{

    $data =
    [
        'text-primary',
        'text-secondary',
        'text-success',
        'text-danger',
        'text-warning',
        'text-info',
        'text-muted',

    ];
    return $data[array_rand($data)];
}

function RecentLogin()
{
    return \App\Models\UserLogin::latest()->get();
}

function RecentLogout()
{
    return \App\Models\UserLogin::whereNotNull('logout_time')->latest()->get();
}
