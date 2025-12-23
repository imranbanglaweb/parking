<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserPolicy extends CustomBasePolicy
{

    public function editUserPermission(User $user, User $model)
    {
        $another = $user->id != $model->id;
        return $another && $this->checkPermission($user, $model, 'edit_user_permissions');
    }

    public function changeUserStatus(User $user, User $model)
    {
        $another = $user->id != $model->id;
        return $another &&  $user->hasPermission('edit_status');
    }

    public function read(User $user, User $model)
    {
        $current = $user->id === $model->id;
        return $current || $this->checkPermission($user, $model, 'read');
    }

    public function edit(User $user, User $model)
    {
       
        $current = $user->id === $model->id;
        return $current ||  $this->checkPermission($user, $model, 'edit');
    }
public function delete(User $user, User $model)
    {
        $current = $user->id === $model->id;
        return $current ||  $this->checkPermission($user, $model, 'delete');
    }
    public function editRoles(User $user, User $model)
    {
        $another = $user->id != $model->id;
       // $sameOffice = $this->preCheck($user, $model);
        return $another && $user->hasPermission('edit_role_users');
    }

    /**
     * Determine whether the user can restore the attendance shift.
     * @param User $user
     * @param User $model
     * @return mixed
     */
    public function restore(User $user, User $model)
    {
        $another = $user->id != $model->id;
        return $another &&  $this->checkPermission($user, $model, 'restore');
    }

    /**
     * Determine whether the user can permanently delete the attendance shift.
     * @param User $user
     * @param User $model
     * @return mixed
     */
    public function forceDelete(User $user, User $model)
    {
        $another = $user->id != $model->id;
        return $another && $this->checkPermission($user, $model, 'force_delete');
    }
}
