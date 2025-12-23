<?php

namespace App\Models;

use App\Facades\Voyager;

class Role extends BaseModel
{
    protected $guarded = [];

    public function users()
    {
        $userModel = Voyager::modelClass('User');

        return $this->belongsToMany($userModel, 'user_roles')
            ->select(app($userModel)->getTable() . '.*')
            ->union($this->hasMany($userModel))->getQuery();
    }

    public function permissions()
    {
        return $this->belongsToMany(Voyager::modelClass('Permission'));
    }
}
