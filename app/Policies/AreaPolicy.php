<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Area;
use Illuminate\Support\Facades\Log;

class AreaPolicy extends CustomBasePolicy {

    public function read(User $user, Area $model) {
        return $this->checkPermission($user, $model, 'read');
    }

    public function add(User $user, Area $model) {
        return $this->checkPermission($user, $model, 'add');
    }

    public function edit(User $user, Area $model) {
       return $this->checkPermission($user, $model, 'edit');
    }

    public function delete(User $user, Area $model) {
       return $this->checkPermission($user, $model, 'delete');
    }


}
