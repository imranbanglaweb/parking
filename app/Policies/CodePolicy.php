<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Code;
use Illuminate\Support\Facades\Log;

class CodePolicy extends CustomBasePolicy {

    public function read(User $user, Code $model) {
        return $this->checkPermission($user, $model, 'read');
    }

    public function add(User $user, Code $model) {
        return $this->checkPermission($user, $model, 'add');
    }

    public function edit(User $user, Code $model) {
       return $this->checkPermission($user, $model, 'edit');
    }

    public function delete(User $user, Code $model) {
       return $this->checkPermission($user, $model, 'delete');
    }


}
