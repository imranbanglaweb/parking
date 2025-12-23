<?php

namespace App\Policies;

use App\Models\User;
use App\Models\VehicleType;
use Illuminate\Support\Facades\Log;

class VehicleTypePolicy extends CustomBasePolicy {

    public function read(User $user, VehicleType $model) {
        return $this->checkPermission($user, $model, 'read');
    }

    public function add(User $user, VehicleType $model) {
        return $this->checkPermission($user, $model, 'add');
    }

    public function edit(User $user, VehicleType $model) {
       return $this->checkPermission($user, $model, 'edit');
    }

    public function delete(User $user, VehicleType $model) {
       return $this->checkPermission($user, $model, 'delete');
    }


}
