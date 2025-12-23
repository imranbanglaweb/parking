<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CarNumber;
use Illuminate\Support\Facades\Log;

class CarNumberPolicy extends CustomBasePolicy {

    public function read(User $user, CarNumber $model) {
        return $this->checkPermission($user, $model, 'read');
    }

    public function add(User $user, CarNumber $model) {
        return $this->checkPermission($user, $model, 'add');
    }

    public function edit(User $user, CarNumber $model) {
       return $this->checkPermission($user, $model, 'edit');
    }

    public function delete(User $user, CarNumber $model) {
       return $this->checkPermission($user, $model, 'delete');
    }


}
