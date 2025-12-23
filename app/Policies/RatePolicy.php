<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Rate;
use Illuminate\Support\Facades\Log;

class RatePolicy extends CustomBasePolicy {

    public function read(User $user, Rate $model) {
        return $this->checkPermission($user, $model, 'read');
    }

    public function add(User $user, Rate $model) {
        return $this->checkPermission($user, $model, 'add');
    }

    public function edit(User $user, Rate $model) {
       return $this->checkPermission($user, $model, 'edit');
    }

    public function delete(User $user, Rate $model) {
       return $this->checkPermission($user, $model, 'delete');
    }


}
