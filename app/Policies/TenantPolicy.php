<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Tenant;
use Illuminate\Support\Facades\Log;

class TenantPolicy extends CustomBasePolicy {

    public function read(User $user, Tenant $model) {
        return $this->checkPermission($user, $model, 'read');
    }

    public function add(User $user, Tenant $model) {
        return $this->checkPermission($user, $model, 'add');
    }

    public function edit(User $user, Tenant $model) {
       return $this->checkPermission($user, $model, 'edit');
    }

    public function delete(User $user, Tenant $model) {
       return $this->checkPermission($user, $model, 'delete');
    }


}
