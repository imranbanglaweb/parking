<?php

namespace App\Listeners;

use App\RolePermission;
use App\UsersPermission;
use TCG\Voyager\Events\BreadDataAdded;

class AddUserPermission
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param BreadDataAdded $event
     * @return void
     */
    public function handle(BreadDataAdded $event)
    {
//        $RolePermission = new RolePermission();
//        $UsersPermission = new UsersPermission();
//        $allPermissions = $RolePermission::where('role_id', $event->data->role_id)->get();
//        foreach ($allPermissions as $allPermission) {
//            $data = array('permission_id' => $allPermission->permission_id, "user_id" => $event->data->id);
//            $UsersPermission::insert($data);
//        }

    }
}
