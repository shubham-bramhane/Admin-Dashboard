<?php


function modulesList(){
   return [
    [
        'id' => 1,
        'slug' => 'users'
    ],
    [
        'id' => 2,
        'slug' => 'roles'
    ],
    [

        'id' => 3,
        'slug' => 'customers'

    ]
];}


function runTimeChecked($myId, $matchId)
{
    if ($myId == $matchId)
        return 'checked';
}
