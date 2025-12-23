<?php

namespace App\Models;

use App\Facades\Voyager;

class UsersPermission extends BaseModel
{
    public $timestamps = true;

    protected $table = "users_permissions";
    protected $fillable = ['user_id', 'permission_id', 'status'];
    protected $casts = [
        'status' => 'boolean',
    ];

    public function permission()
    {
        return $this->belongsTo(Voyager::modelClass('Permission'),'permission_id','id');
    }
}
