<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Station;
use Illuminate\Support\Facades\Log;

class StationPolicy extends CustomBasePolicy {

    public function read(User $user, Station $model) {
        return $this->checkPermission($user, $model, 'read');
    }

    public function add(User $user, Station $model) {
        return $this->checkPermission($user, $model, 'add');
    }

    public function edit(User $user, Station $model) {
       return $this->checkPermission($user, $model, 'edit');
    }

    public function delete(User $user, Station $model) {
       return $this->checkPermission($user, $model, 'delete');
    }


}
