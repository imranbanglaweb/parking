<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CustomerCategory;
use Illuminate\Support\Facades\Log;

class CustomerCategoryPolicy extends CustomBasePolicy {

    public function read(User $user, CustomerCategory $model) {
        return $this->checkPermission($user, $model, 'read');
    }

    public function add(User $user, CustomerCategory $model) {
        return $this->checkPermission($user, $model, 'add');
    }

    public function edit(User $user, CustomerCategory $model) {
       return $this->checkPermission($user, $model, 'edit');
    }

    public function delete(User $user, CustomerCategory $model) {
       return $this->checkPermission($user, $model, 'delete');
    }


}
